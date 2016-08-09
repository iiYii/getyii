<?php

namespace frontend\models;

use common\components\db\ActiveRecord;
use common\models\Post;
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
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'user_id', 'post_id', 'type'], 'required'],
            [['from_user_id', 'user_id', 'post_id', 'comment_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getLable($type)
    {
        switch ($type) {
            case 'new_comment':
                $lable = Yii::t('app', 'Your follow topic have new reply:');
                break;
            case 'attention':
                $lable = Yii::t('app', 'Attented topic has new reply:');
                break;
            case 'at':
                $lable = Yii::t('app', 'Mention you At:');
                break;
            case 'at_topic':
                $lable = Yii::t('app', 'Mention you topic At:');
                break;
            case 'at_tweet':
                $lable = Yii::t('app', 'Mention you tweet At:');
                break;
            case 'topic_favorite':
                $lable = Yii::t('app', 'Favorited your topic:');
                break;
            case 'topic_thanks':
                $lable = Yii::t('app', 'Thanks your topic:');
                break;
            case 'topic_follow':
                $lable = Yii::t('app', 'Attented your topic:');
                break;
            case 'topic_like':
                $lable = Yii::t('app', 'Up Vote your topic');
                break;
            case 'tweet_like':
                $lable = Yii::t('app', 'Up Vote your tweet');
                break;
            case 'comment_like':
                $lable = Yii::t('app', 'Up Vote your reply');
                break;
            case 'topic_mark_wiki':
                $lable = Yii::t('app', 'has mark your topic as wiki:');
                break;
            case 'topic_mark_excellent':
                $lable = Yii::t('app', 'has recomended your topic:');
                break;
            case 'comment_append':
                $lable = Yii::t('app', 'Commented topic has new update:');
                break;
            case 'attention_append':
                $lable = Yii::t('app', 'Attented topic has new update:');
                break;

            default:
                $lable = '';
                break;
        }
        return $lable;
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


}
