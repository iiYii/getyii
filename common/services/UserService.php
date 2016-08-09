<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use common\models\Post;
use common\models\PostComment;
use common\models\User;
use common\models\UserInfo;
use DevGroup\TagDependencyHelper\NamingHelper;
use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\UserMeta;
use yii\caching\TagDependency;

class UserService
{
    /**
     * 获取通知条数
     * @return mixed
     */
    public static function findNotifyCount()
    {
        $user = \Yii::$app->getUser()->getIdentity();
        return $user ? $user->notification_count : null;
    }

    /**
     * 清除通知数
     * @return mixed
     */
    public static function clearNotifyCount()
    {
        return User::updateAll(['notification_count' => '0'], ['id' => \Yii::$app->user->id]);
    }

    /**
     * 赞话题(如果已经赞,则取消赞)
     * @param User $user
     * @param Topic $topic
     * @param $action 动作
     * @return array
     */
    public static function TopicActionA(User $user, Topic $topic, $action)
    {
        return self::toggleType($user, $topic, $action);
    }

    /**
     * 用户对话题其他动作
     * @param User $user
     * @param Post $model
     * @param $action  fa
     * @return array
     */
    public static function TopicActionB(User $user, Post $model, $action)
    {
        $data = [
            'target_id' => $model->id,
            'target_type' => $model->type,
            'user_id' => $user->id,
            'value' => '1',
        ];
        if (!UserMeta::deleteOne($data + ['type' => $action])) { // 删除数据有行数则代表有数据,无行数则添加数据
            $userMeta = new UserMeta();
            $userMeta->setAttributes($data + ['type' => $action]);
            $result = $userMeta->save();
            if ($result) {
                $model->updateCounters([$action . '_count' => 1]);
                if ($action == 'thanks') {
                    UserInfo::updateAllCounters([$action . '_count' => 1], ['user_id' => $model->user_id]);
                }
            }
            return [$result, $userMeta];
        }
        $model->updateCounters([$action . '_count' => -1]);
        if ($action == 'thanks') {
            UserInfo::updateAllCounters([$action . '_count' => -1], ['user_id' => $model->user_id]);
        }

        return [true, null];
    }

    /**
     * 对评论点赞
     * @param User $user
     * @param PostComment $comment
     * @param $action
     * @return array
     */
    public static function CommentAction(User $user, PostComment $comment, $action)
    {
        $data = [
            'target_id' => $comment->id,
            'target_type' => $comment::TYPE,
            'user_id' => $user->id,
            'value' => '1',
        ];
        if (!UserMeta::deleteOne($data + ['type' => $action])) { // 删除数据有行数则代表有数据,无行数则添加数据
            $userMeta = new UserMeta();
            $userMeta->setAttributes($data + ['type' => $action]);
            $result = $userMeta->save();
            if ($result) {
                $comment->updateCounters([$action . '_count' => 1]);
                // 更新个人总统计
                UserInfo::updateAllCounters([$action . '_count' => 1], ['user_id' => $comment->user_id]);
            }
            return [$result, $userMeta];
        }
        $comment->updateCounters([$action . '_count' => -1]);
        // 更新个人总统计
        UserInfo::updateAllCounters([$action . '_count' => -1], ['user_id' => $comment->user_id]);
        return [true, null];
    }

    /**
     * 喝倒彩或者赞
     * @param User $user
     * @param Post $model
     * @param $action 动作
     * @return array
     */
    protected static function toggleType(User $user, Post $model, $action)
    {
        $data = [
            'target_id' => $model->id,
            'target_type' => $model->type,
            'user_id' => $user->id,
            'value' => '1',
        ];
        if (!UserMeta::deleteOne($data + ['type' => $action])) { // 删除数据有行数则代表有数据,无行数则添加数据
            $userMeta = new UserMeta();
            $userMeta->setAttributes($data + ['type' => $action]);
            $result = $userMeta->save();
            if ($result) { // 如果是新增数据, 删除掉Hate的同类型数据
                $attributeName = ($action == 'like' ? 'hate' : 'like');
                $attributes = [$action . '_count' => 1];
                if (UserMeta::deleteOne($data + ['type' => $attributeName])) { // 如果有删除hate数据, hate_count也要-1
                    $attributes[$attributeName . '_count'] = -1;
                }
                //更新版块统计
                $model->updateCounters($attributes);
                // 更新个人总统计
                UserInfo::updateAllCounters($attributes, ['user_id' => $model->user_id]);
            }
            return [$result, $userMeta];
        }
        $model->updateCounters([$action . '_count' => -1]);
        UserInfo::updateAllCounters([$action . '_count' => -1], ['user_id' => $model->user_id]);

        return [true, null];
    }


    /**
     * 查找活跃用户
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findActiveUser($limit = 12)
    {
        $cacheKey = md5(__METHOD__ . $limit);
        if (false === $items = \Yii::$app->cache->get($cacheKey)) {
            $items = User::find()
                ->joinWith(['merit', 'userInfo'])
                ->where([User::tableName() . '.status' => 10])
                ->orderBy(['merit' => SORT_DESC, '(like_count+thanks_count)' => SORT_DESC])
                ->limit($limit)
                ->all();
            //一天缓存
            \Yii::$app->cache->set($cacheKey, $items, 86400,
                new TagDependency([
                    'tags' => [NamingHelper::getCommonTag(User::className())]
                ])
            );
        }
        return $items;
    }
}