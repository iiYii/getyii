<?php

namespace common\models;

use Yii;
use common\models\User;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "post_comment".
 *
 * @property integer $id
 * @property string $parent
 * @property string $post_id
 * @property string $comment
 * @property integer $status
 * @property string $user_id
 * @property string $like_count
 * @property string $ip
 * @property string $created_at
 * @property string $updated_at
 */
class PostComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'post_id', 'status', 'user_id', 'like_count', 'created_at', 'updated_at'], 'integer'],
            [['post_id', 'comment', 'user_id', 'ip'], 'required'],
            [['comment'], 'string'],
            [['ip'], 'string', 'max' => 255]
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => '父级评论',
            'post_id' => '文章ID',
            'comment' => '评论',
            'status' => '1为正常 0为禁用',
            'user_id' => '用户ID',
            'like_count' => '喜欢数',
            'ip' => '评论者ip地址',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
