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
use yii\base\Exception;

class NotificationService
{
    public $notifiedUsers = [];

    public function newReplyNotify(User $fromUser, Topic $topic, PostComment $comment, $rawComment = '')
    {
        foreach ($topic->follower as $key => $value) {
            $users[$value->user_id] = $value->user_id;
        }

        // 通知关注的用户
        $this->batchNotify('follow', $fromUser, $users, $topic, $comment);

        // Notify mentioned users
        $this->batchNotify(
            'at',
            $fromUser,
            $this->removeDuplication($comment->parse($rawComment)),
            $topic,
            $comment);
    }

    /**
     * 批量处理通知
     * @param $type
     * @param User $fromUser
     * @param $users
     * @param Post $post
     * @param PostComment $comment
     * @param null $content
     * @throws Exception
     */
    public function batchNotify($type, User $fromUser, $users, Post $post, PostComment $comment = null, $content = null)
    {
        foreach ($users as $key => $value) {
            if ($fromUser->id == $key) {
                continue;
            }
            $model = new Notification();
            $model->setAttributes([
                'from_user_id' => $fromUser->id,
                'user_id'      => $key,
                'post_id'      => $post->id,
                'comment_id'   => $content ?: $comment->id,
                'data'         => $content ?: $comment->comment,
                'type'         => $type,
            ]);
            if ($model->save()) {
                User::updateAllCounters(['notification_count' => 1], ['id' => $key]);
            } else {
                throw new Exception(array_values($model->getFirstErrors())[0]);
            }
        }
    }

    /**
     * 去掉重复 避免通知重复
     * @param $users
     * @return array
     */
    public function removeDuplication($users)
    {
        $notYetNotifyUsers = [];
        foreach ($users as $key => $value) {
            if (!in_array($key, $this->notifiedUsers)) {
                $notYetNotifyUsers[$key] = $value;
                $this->notifiedUsers[] = $key;
            }
        }
        return $notYetNotifyUsers;
    }
}