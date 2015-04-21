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

class NotificationService
{
    public $notifiedUsers = [];

    public function newReplyNotify(User $fromUser, Topic $topic, PostComment $comment)
    {
        $notify = new Notification();
        // 通知关注的用户
        $notify->batchNotify(
            'follow',
            $fromUser,
            $this->removeDuplication($topic->follower),
            $topic,
            $comment);
        // Notify mentioned users
        //$notify->batchNotify(
        //    'at',
        //    $fromUser,
        //    self::removeDuplication($mentionParser->users),
        //    $topic,
        //    $comment);
    }

    /**
     * 去掉重复 避免通知重复
     * @param $users
     * @return array
     */
    public function removeDuplication($users)
    {
        $notYetNotifyUsers = [];
        foreach ($users as $user) {
            if (!in_array($user->id, $this->notifiedUsers)) {
                $notYetNotifyUsers[] = $user;
                $this->notifiedUsers[] = $user->id;
            }
        }
        return $notYetNotifyUsers;
    }
}