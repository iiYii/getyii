<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use common\models\User;
use frontend\modules\topic\models\Topic;

class TopicService extends PostService
{

    public function userDoAction($id, $action)
    {
        $topic = Topic::findTopic($id);
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        if (in_array($action, ['like', 'hate'])) {
            return UserService::TopicActionA($user, $topic, $action);
        } else {
            return UserService::TopicActionB($user, $topic, $action);
        }
    }

    /**
     * 撤销帖子
     * @param Topic $topic
     */
    public static function revoke(Topic $topic)
    {
        $topic->setAttributes(['status' => Topic::STATUS_ACTIVE]);
        $topic->save();
    }

    /**
     * 加精华
     * @param Topic $topic
     */
    public static function excellent(Topic $topic)
    {
        $action = ($topic->status == Topic::STATUS_ACTIVE) ? Topic::STATUS_EXCELLENT : Topic::STATUS_ACTIVE;
        $topic->setAttributes(['status' => $action]);
        $topic->save();
    }
}