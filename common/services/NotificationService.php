<?php
/**
 * author     : forecho <caizh@snsshop.com>
 * createTime : 2015/4/21 16:56
 * description:
 */

namespace common\services;

use common\models\PostComment;
use common\models\User;
use frontend\models\Notification;
use frontend\modules\topic\models\Topic;
use common\models\Post;
use frontend\modules\user\models\UserMeta;
use yii\base\Exception;
use yii\helpers\VarDumper;

class NotificationService
{
    public $notifiedUsers = [];

    /**
     * 评论和@用户会有通知
     * @param User $fromUser
     * @param Topic $topic
     * @param PostComment $comment
     * @param $atUsers
     */
    public function newReplyNotify(User $fromUser, Topic $topic, PostComment $comment, $atUsers)
    {
        $users = [];
        foreach ($topic->follower as $key => $value) {
            $users[$value->user_id] = $value->user_id;
        }

        // Notify mentioned users
        if (!$this->batchNotify('at', $fromUser, $atUsers, $topic, $comment)) {
            // 通知关注的用户
            $this->batchNotify('new_comment', $fromUser, $users, $topic, $comment);
        }
    }

    /**
     * 内容@用户会有通知
     * @param User $fromUser
     * @param Post $post
     * @param [] $users
     * @throws Exception
     */
    public function newPostNotify(User $fromUser, Post $post, $users)
    {
        $this->batchNotify('at_' . $post->type, $fromUser, $users, $post);
    }

    /**
     * 点赞和其他动作通知
     * @param $type
     * @param $fromUserId
     * @param $toUserId
     * @param Post $post
     * @param PostComment $comment
     * @throws Exception
     */
    public function newActionNotify($type, $fromUserId, $toUserId, Post $post, PostComment $comment = null)
    {

        $model = new Notification();

        $model->setAttributes([
            'from_user_id' => $fromUserId,
            'user_id' => $toUserId,
            'post_id' => $post->id,
            'comment_id' => $comment ? $comment->id : 0,
            'data' => $comment ? $comment->comment : $post->content,
            'type' => $type,
        ]);

        if ($model->save()) {
            User::updateAllCounters(['notification_count' => 1], ['id' => $toUserId]);
        } else {
            throw new Exception(array_values($model->getFirstErrors())[0]);
        }
    }

    /**
     * 批量处理通知
     * @param $type
     * @param User $fromUser
     * @param $users
     * @param Post $post
     * @param PostComment $comment
     * @return bool
     * @throws Exception
     */
    public function batchNotify($type, User $fromUser, $users, Post $post, PostComment $comment = null)
    {
        foreach ($users as $key => $value) {
            if ($fromUser->id == $key) {
                continue;
            }
            $model = new Notification();
            $model->setAttributes([
                'from_user_id' => $fromUser->id,
                'user_id' => $key,
                'post_id' => $post->id,
                'comment_id' => $comment ? $comment->id : 0,
                'data' => self::getNotifyData($type, $comment ? $comment->comment : $post->content),
                'type' => $type,
            ]);
            $this->notifiedUsers[] = $key;
            if ($model->save()) {
                User::updateAllCounters(['notification_count' => 1], ['id' => $key]);
            } else {
                throw new Exception(array_values($model->getFirstErrors())[0]);
            }
        }
        return count($this->notifiedUsers);
    }

    /**
     * 查找用户的动作通知
     * @param UserMeta $meta
     * @return null|Notification
     */
    public function findUserActionNotify(UserMeta $meta)
    {
        if ($meta->target_type == 'comment') {
            $condition['comment_id'] = $meta->target_id;
        } else {
            $condition['post_id'] = $meta->target_id;
        }
        return Notification::findOne([
                'from_user_id' => $meta->user_id,
                'type' => $meta->target_type . '_' . $meta->type,
            ] + $condition);
    }

    /**
     * @param $type
     * @param $data
     * @return string
     */
    public static function getNotifyData($type, $data)
    {
        if (in_array($type, ['topic_like', 'topic_favorite', 'topic_thanks', 'at_topic'])) {
            return '';
        }
        return $data;
    }
}