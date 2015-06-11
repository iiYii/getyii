<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property integer $create_at
 * @property integer $update_at
 * @property string $type
 * @property string $title
 * @property string $content
 * @property string $video_url
 * @property integer $user_id
 * @property integer $status
 */
class Video extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at', 'user_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['type'], 'string', 'max' => 32],
            [['title', 'video_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'type' => 'Type',
            'title' => 'Title',
            'content' => 'Content',
            'video_url' => 'Video Url',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id'])
    }
}
