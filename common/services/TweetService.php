<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\models\Notification;
use frontend\modules\topic\models\Topic;

class TweetService extends PostService
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

    /**
     * 删除帖子
     * @param Topic $topic
     */
    public static function delete(Topic $topic)
    {
        $topic->setAttributes(['status' => Topic::STATUS_DELETED]);
        $topic->save();
        Notification::updateAll(['status' => Topic::STATUS_DELETED], ['post_id' => $topic->id]);

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

    /**
     * 更新缓存
     * @param Topic $topic
     */
    public static function updateCache(Topic $topic)
    {
        \Yii::$app->cache->set('topic' . $topic->id, $topic, 0);
    }
}