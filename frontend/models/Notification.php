<?php

namespace frontend\models;

use common\components\db\ActiveRecord;
use common\models\Post;
use common\models\PostComment;
use common\models\User;
use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property string $from_user_id
 * @property string $user_id
 * @property string $post_id
 * @property string $comment_id
 * @property string $type
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 */
class Notification extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'user_id', 'post_id', 'type', 'data'], 'required'],
            [['from_user_id', 'user_id', 'post_id', 'comment_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'from_user_id' => 'From User ID',
            'user_id'      => 'User ID',
            'post_id'      => 'Post ID',
            'comment_id'   => 'Comment ID',
            'type'         => 'Type',
            'data'         => 'Data',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }

    /**
     * 批量处理通知
     * @param $type
     * @param User $fromUser
     * @param $users
     * @param Post $post
     * @param PostComment $comment
     * @param null $content
     * @return bool
     */
    public function batchNotify($type, User $fromUser, $users, Post $post, PostComment $comment = null, $content = null)
    {
        foreach ($users as $toUser) {
            if ($fromUser->id == $toUser->id) {
                continue;
            }

            $this->setAttributes([
                'from_user_id' => $fromUser->id,
                'user_id'      => $toUser->id,
                'post_id'      => $post->id,
                'comment_id'   => $content ?: $comment->id,
                'data'         => $content ?: $comment->comment,
                'type'         => $type,
            ]);
            if ($this->save()) {
                User::updateAllCounters(['notification_count' => 1], ['id' => $toUser->id]);
                return true;
            } else {
                return array_values($this->getFirstErrors())[0];
            }
        }
    }
}
