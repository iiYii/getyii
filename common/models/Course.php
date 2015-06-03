<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "course".
 *
 * @property integer $id
 * @property integer $create_at
 * @property integer $update_at
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $video_url
 * @property integer $course_terms
 * @property string $excerpt
 * @property string $image
 */
class Course extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at', 'user_id', 'course_terms'], 'required'],
            [['create_at', 'update_at', 'user_id', 'course_terms'], 'integer'],
            [['content'], 'string'],
            [['title', 'video_url', 'excerpt', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'user_id' => '作者',
            'title' => '标题',
            'content' => '内容',
            'video_url' => '视频地址',
            'course_terms' => '课程分类',
            'excerpt' => '简介',
            'image' => '特殊图片',
        ];
    }

    /**
    * 获取用户
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
    *获取用户信息
    */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'user_id']);
    }


}
