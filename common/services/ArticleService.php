<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\models\Notification;
use frontend\modules\article\models\Article;

class ArticleService extends PostService
{

    public function userDoAction($id, $action)
    {
        $topic = Article::findTopic($id);
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

    /**
     * 加推荐
     * @param Topic $topic
     */
    public static function recommend(Topic $topic)
    {
        $action = ($topic->recommend == Topic::RECOMMEND_INACTIVE) ? Topic::RECOMMEND_ACTIVE : Topic::RECOMMEND_INACTIVE;
        $topic->setAttributes(['recommend' => $action]);
        $topic->save();
    }

    /**
     * 加置顶
     * @param Topic $topic
     */
    public static function top(Topic $topic)
    {
        $action = ($topic->top == Topic::TOP_INACTIVE) ? Topic::TOP_ACTIVE : Topic::TOP_INACTIVE;
        $topic->setAttributes(['top' => $action]);
        $topic->save();
    }
}