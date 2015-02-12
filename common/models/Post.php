<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;

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
class Post extends ActiveRecord
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
            [['title', 'content', 'post_meta_id', 'tags'], 'required'],
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
            'post_meta_id' => '文章分类',
            'user_id' => '作者ID',
            'title' => '标题',
            'author' => '作者',
            'excerpt' => '摘要',
            'image' => '封面图片',
            'content' => '内容',
            'tags' => '标签 用空格隔开',
            'view_count' => '查看数',
            'comment_count' => '评论数',
            'favorite_count' => '收藏数',
            'like_count' => '喜欢数',
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


    public function getLike()
    {
        $model = new UserMeta();
        return $model->isUserAction('like', $this->id);
    }

    public function getHate()
    {
        $model = new UserMeta();
        return $model->isUserAction('hate', $this->id);
    }

    public function getFavorite()
    {
        $model = new UserMeta();
        return $model->isUserAction('favorite', $this->id);
    }

    public function getThanks()
    {
        $model = new UserMeta();
        return $model->isUserAction('thanks', $this->id);
    }

    public function getCategory()
    {
        return $this->hasOne(PostMeta::className(), ['id' => 'post_meta_id']);
    }

    public function getIsCurrent()
    {
        return $this->user_id == Yii::$app->user->id;
    }

    /**
     * 添加标签
     * @param array $tags
     * @return bool
     */
    public function addTags(array $tags)
    {
        $return = false;
        $tagItem = new PostTag();
        foreach ($tags as $tag) {
            $tagRaw = false;
            $_tagItem = clone $tagItem;
            $tagRaw = $_tagItem::findOne(['name' => $tag]);
            if (!$tagRaw) {
                $_tagItem->setAttributes([
                    'name' => $tag,
                    'count' => 1,
                ]);
                if ($_tagItem->save()) {
                    $return = true;
                }
            } else {
                $tagRaw->updateCounters(['count' => 1]);
            }
        }
        return $return;
    }


}
