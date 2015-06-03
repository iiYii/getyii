<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $type
 * @property integer $post_meta_id
 * @property integer $user_id
 * @property string $title
 * @property string $author
 * @property string $excerpt
 * @property string $image
 * @property string $content
 * @property string $tags
 * @property integer $view_count
 * @property integer $comment_count
 * @property integer $favorite_count
 * @property integer $like_count
 * @property integer $thanks_count
 * @property integer $hate_count
 * @property integer $status
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 */
class Post extends ActiveRecord
{
    /**
     * 博客文章
     */
    const TYPE_BLOG = 'blog';

    /**
     * 社区话题
     */
    const TYPE_TOPIC = 'topic';

    /**
     * 置顶
     */
    const STATUS_TOP = 3;

    /**
     * 推荐
     */
    const STATUS_GOOD = 2;

    /**
     * 发布
     */
    const STATUS_ACTIVE = 1;

    /**
     * 删除
     */
    const STATUS_DELETED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_meta_id', 'title', 'content'], 'required'],
            [['post_meta_id', 'user_id', 'view_count', 'comment_count', 'favorite_count', 'like_count', 'thanks_count', 'hate_count', 'status', 'order', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'min' => 2],
            [['type'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 255, 'min' => 2],
            [['excerpt', 'image', 'tags'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '内容类型',
            'post_meta_id' => '分类',
            'user_id' => '作者ID',
            'title' => '标题',
            'author' => '作者',
            'excerpt' => '摘要',
            'image' => '封面图片',
            'content' => '内容',
            'tags' => '标签 用英文逗号隔开',
            'view_count' => '查看数',
            'comment_count' => '评论数',
            'favorite_count' => '收藏数',
            'like_count' => '喜欢数',
            'thanks_count' => '感谢数',
            'hate_count' => '讨厌数',
            'status' => '状态 1:发布 0：草稿',
            'order' => '排序 0最大',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
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


    public function getCategory()
    {
        return $this->hasOne(PostMeta::className(), ['id' => 'post_meta_id']);
    }

    public function isCurrent()
    {
        return $this->user_id == Yii::$app->user->id;
    }





}
