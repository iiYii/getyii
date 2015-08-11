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
     * @param string $rawComment
     * @throws Exception
     */
    public function newReplyNotify(User $fromUser, Topic $topic, PostComment $comment, $rawComment = '')
    {
        foreach ($topic->follower as $key => $value) {
            $users[$value->user_id] = $value->user_id;
        }

        // Notify mentioned users
        $this->batchNotify(
            'at',
            $fromUser,
            $this->removeDuplication($comment->parse($rawComment)),
            $topic,
            $comment);

        // 通知关注的用户
        //print_r($users);die;
        $this->batchNotify('new_comment', $fromUser, $this->removeDuplication($users), $topic, $comment);
    }

    /**
     * 内容@用户会有通知
     * @param User $fromUser
     * @param Post $post
     * @param string $rawContent
     * @throws Exception
     */
    public function newPostNotify(User $fromUser, Post $post, $rawContent = '')
    {
        $this->batchNotify(
            'at_' . $post->type,
            $fromUser,
            $this->removeDuplication(PostService::parse($rawContent)),
            $post
        );
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
                'data' => $comment ? $comment->comment : $post->content,
                'type' => $type,
            ]);
            $this->notifiedUsers[] = $key;
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

    /**
     * 查找用户的动作通知
     * @param UserMeta $meta
     * @return null|static
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
}