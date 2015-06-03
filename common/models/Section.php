<?php

namespace app\models;

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property integer $create_at
 * @property integer $update_at
 * @property string $title
 * @property string $excerpt
 * @property string $video_url
 * @property string $image
 * @property integer $user_id
 * @property integer $status
 * @property integer $type
 * @property integer $parent_id
 * @property string $course_id
 */
class Section extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'required'],
            [['create_at', 'update_at', 'user_id', 'status', 'type', 'parent_id'], 'integer'],
            [['title', 'excerpt', 'video_url', 'image'], 'string', 'max' => 255],
            [['course_id'], 'string', 'max' => 45]
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
            'title' => '标题',
            'excerpt' => '简介',
            'video_url' => '视频地址',
            'image' => '特殊图片',
            'user_id' => '用户id',
            'status' => '状态',
            'type' => '类型',
            'parent_id' => '父级ID',
            'course_id' => '课程',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'user_id']);
    }
}
