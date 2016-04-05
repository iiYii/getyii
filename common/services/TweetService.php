<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\modules\topic\models\Topic;
use frontend\modules\tweet\models\Tweet;
use yii\helpers\Url;

class TweetService extends PostService
{

    public function userDoAction($id, $action)
    {
        $topic = Tweet::findTweet($id);
        $user = \Yii::$app->user->getIdentity();
        return UserService::TopicActionB($user, $topic, $action);
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


    public static function replaceTopic($content)
    {
        preg_match_all("/\#([^\#\r\n\s]*)\#/i", $content, $topic);
        if (isset($topic[1])) {
            foreach ($topic[1] as $key => $value) {
                if ($value) {
                    $search = '#' . $value . '#';
                    $url = Url::to(['/tweet/default/index', 'topic' => $value]);
                    $place = "[{$search}]({$url}) ";
                    $content = str_replace($search, $place, $content);
                }
            }
        }
        return $content;
    }
}