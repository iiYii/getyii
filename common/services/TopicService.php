<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use common\models\PostComment;
use frontend\modules\topic\models\Topic;
use yii\web\NotFoundHttpException;

class TopicService
{
    /**
     * 通过ID获取指定话题
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|static
     * @throws NotFoundHttpException
     */
    public function findTopic($id)
    {
        if (($model = Topic::findOne(['id' => $id, 'type' => 'topic'])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 通过ID获取指定评论
     */
    public function findComment($id, \Closure $callback = null)
    {
        $query = PostComment::find();
        $callback !== null && $callback($query);
        if (($model = $query->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}