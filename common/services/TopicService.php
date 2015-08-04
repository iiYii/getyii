<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\models\Notification;
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

    /**
     * 过滤内容
     */
    public function filterContent($content)
    {
        $content = strtolower($content);
        $content = trim($content);
        $data = ['test', '测试'];
        if (in_array($content, $data)) {
            return false;
        }
        $action = ['+1', '赞', '很赞', '喜欢', '收藏', 'mark', '写的不错', '不错', '给力'];
        if (in_array($content, $action)) {
            return false;
        }
        return true;
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
}