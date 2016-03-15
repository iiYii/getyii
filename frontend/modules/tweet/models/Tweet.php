<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午5:57
 * description:
 */

namespace frontend\modules\tweet\models;

use common\models\Post;
use frontend\modules\user\models\UserMeta;
use yii\web\NotFoundHttpException;
use Yii;

class Tweet extends Post
{
    const TYPE = 'tweet';

    public function getLike()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'like', $this->id);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['post_meta_id', 'user_id', 'view_count', 'comment_count', 'favorite_count', 'like_count', 'thanks_count', 'hate_count', 'status', 'order', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'min' => 3, 'max' => 500],
            [['post_meta_id'], 'default', 'value' => 0],
            [['title'], 'default', 'value' => ''],
        ];
    }

    /**
     * 通过ID获取指定话题
     * @param $id
     * @param string $condition
     * @return array|null|\yii\db\ActiveRecord|static
     * @throws NotFoundHttpException
     */
    public static function findModel($id, $condition = '')
    {
        if (!$model = Yii::$app->cache->get('topic' . $id)) {
            $model = static::find()
                ->where($condition)
                ->andWhere(['id' => $id, 'type' => self::TYPE])
                ->one();
        }
        if ($model) {
            Yii::$app->cache->set('topic' . $id, $model, 0);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * 通过ID获取指定动弹
     * @param $id
     * @return array|Topic|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function findTweet($id)
    {
        return static::findModel($id, ['>=', 'status', self::STATUS_ACTIVE]);
    }

    /**
     * 获取已经删除过的动弹
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function findDeletedTweet($id)
    {
        return static::findModel($id, ['>=', 'status', self::STATUS_DELETED]);
    }

}