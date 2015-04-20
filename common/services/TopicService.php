<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\modules\topic\models\Topic;

class TopicService
{

    public function userDoAction($id, $action)
    {
        $topic = Topic::findTopic($id);
        $user = \Yii::$app->user->getIdentity();
        if (in_array($action, ['like', 'hate'])) {
            return UserService::TopicActionA($user, $topic, $action);
        } else {
            return UserService::TopicActionB($user, $topic, $action);
        }
    }

}