<?php

namespace frontend\models;

use common\components\db\ActiveRecord;
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


}
