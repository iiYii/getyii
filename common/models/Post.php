<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $post_meta_id
 * @property string $user_id
 * @property string $title
 * @property string $author
 * @property string $excerpt
 * @property string $image
 * @property string $content
 * @property string $tags
 * @property string $view_count
 * @property string $comment_count
 * @property string $favorite_count
 * @property string $like_count
 * @property string $hate_count
 * @property integer $status
 * @property string $order
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
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
            [['post_meta_id', 'user_id', 'view_count', 'comment_count', 'favorite_count', 'like_count', 'hate_count', 'status', 'order', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'content', 'tags'], 'required'],
            [['content'], 'string'],
            [['title', 'excerpt', 'image', 'tags'], 'string', 'max' => 255],
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
            'post_meta_id' => 'Post Meta ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'author' => 'Author',
            'excerpt' => 'Excerpt',
            'image' => 'Image',
            'content' => 'Content',
            'tags' => 'Tags',
            'view_count' => 'View Count',
            'comment_count' => 'Comment Count',
            'favorite_count' => 'Favorite Count',
            'like_count' => 'Like Count',
            'hate_count' => 'Hate Count',
            'status' => 'Status',
            'order' => 'Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
