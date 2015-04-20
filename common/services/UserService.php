<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use common\models\Post;
use common\models\User;
use common\models\UserInfo;
use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\UserMeta;
use yii\web\NotFoundHttpException;

class UserService
{

    /**
     * 喝倒彩或者赞
     * @param User $user
     * @param Post $model
     * @param $type 动作
     * @return array
     */
    protected static function toggleType(User $user, Post $model, $type)
    {
        $data = [
            'target_id' => $model->id,
            'target_type' => $model::TYPE,
            'user_id' => $user->id,
            'value' => '1',
        ];
        if (!UserMeta::deleteAll($data + ['type' => $type])) { // 删除数据有行数则代表有数据,无行数则添加数据
            $userMeta = new UserMeta();
            $userMeta->setAttributes($data + ['type' => $type]);
            $result = $userMeta->save();
            if ($result) { // 如果是新增数据, 删除掉Hate的同类型数据
                $attributeName = ($type == 'like' ? 'hate' : 'like');
                $attributes = [$type . '_count' => 1];
                if (UserMeta::deleteAll($data + ['type' => $attributeName])) { // 如果有删除hate数据, hate_count也要-1
                    $attributes[$attributeName . '_count'] = -1;
                }
                //更新版块统计
                $model->updateCounters($attributes);
                // 更新个人总统计
                UserInfo::updateAllCounters($attributes, ['user_id' => $user->id]);
            }
            return [$result, $userMeta];
        }
        $model->updateCounters([$type . '_count' => -1]);
        return [true, null];
    }


    /**
     * 赞话题(如果已经赞,则取消赞)
     * @param User $user
     * @param Topic $topic
     * @return array
     */
    public static function TopicAction(User $user, Topic $topic, $action)
    {
        return self::toggleType($user, $topic, $action);
    }

    /**
     * 收藏和感谢
     * @param $type string 操作类型, like 或 hate
     * @param $targetId int 文章ID
     * @return bool|string string为错误提示, bool为操作成功还是失败
     */
    protected function actionLog($type, $targetId)
    {
        $userId = Yii::$app->user->getId();
        //查找数据库是否有记录
        $model = self::find()
            ->where([
                'user_id' => $userId,
                'type' => $type,
                'target_id' => $targetId,
                'target_type' => 'post'
            ])->one();
        $return = $active = false;
        if ($model) {
            $num = $model->delete();// 有记录则取消记录
            if ($model->type == $type) { //相应记录删除后直接返回取消结果
                $return = $num >= 0;
            }
        } else {
            $this->setAttributes([
                'user_id' => $userId,
                'target_id' => $targetId,
                'type' => $type,
                'target_type' => 'post',
            ]);
            if ($this->save()) {
                $return = $active = true;
            } else {
                $return = array_values($this->getFirstErrors())[0];
            }
        }

        if ($return == true) { // 更新记数
            $model = Post::findOne($targetId);
            $attributeName = $type . '_count';
            $attributes = [
                $attributeName => $active ? 1 : ($model->$attributeName > 0 ? -1 : 0),
            ];

            //更新版块统计
            $model->updateCounters($attributes);
            // 更新个人总统计
            UserInfo::updateAllCounters($attributes, ['user_id' => $userId]);
        }
        return $return;
    }
}