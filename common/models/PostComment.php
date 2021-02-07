<?php

namespace common\models;

use common\components\db\ActiveRecord;
use common\services\NotificationService;
use common\services\PostService;
use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\UserMeta;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yiier\antiSpam\SpamValidator;

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
 *
 * @property Topic $topic
 * @property Post $post
 */
class PostComment extends ActiveRecord
{
    const TYPE = 'comment';
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
        return '{{%post_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'post_id', 'status', 'user_id', 'like_count', 'created_at', 'updated_at'], 'integer'],
            [['post_id', 'comment', 'user_id', 'ip'], 'required'],
            [['comment'], 'string', 'min' => 1],
            ['comment', SpamValidator::className(), 'message' => '请勿发表垃圾内容'],
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

    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'post_id'])->where(['type' => 'topic']);
    }

    public function getLike()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'like', $this->id);
    }

    /**
     * 通过ID获取指定评论
     * @param $id
     * @param string $condition
     * @return array|null|\yii\db\ActiveRecord|static
     * @throws NotFoundHttpException
     */
    public static function findModel($id, $condition = '')
    {
        if (!$model = Yii::$app->cache->get('comment' . $id)) {
            $model = static::find()
                ->where(['id' => $id])
                ->andWhere($condition)
                ->one();
        }
        if ($model !== null) {
            Yii::$app->cache->set('comment' . $id, $model, 0);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 通过ID获取指定评论
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|static
     * @throws NotFoundHttpException
     */
    public static function findComment($id)
    {
        return static::findModel($id, ['status' => self::STATUS_ACTIVE]);
    }

    /**
     * 获取已经删除过的评论
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function findDeletedComment($id)
    {
        return static::findModel($id, ['status' => self::STATUS_DELETED]);
    }

    /**
     * 评论列表
     * @param $postId
     * @return Query
     */
    public static function findCommentList($postId)
    {
        return static::find()->with('user')->where(['post_id' => $postId]);
    }

    /**
     * 自己写的评论
     * @return bool
     */
    public function isCurrent()
    {
        return $this->user_id == Yii::$app->user->id;
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

    public $atUsers;

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->comment = PostService::contentComment($this->comment, $this);
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $post = $this->topic;

        (new UserMeta())->saveNewMeta('topic', $this->post_id, 'follow');
        (new NotificationService())->newReplyNotify(\Yii::$app->user->identity, $post, $this, $this->atUsers);
        // 更新回复时间
        $post->lastCommentToUpdate(\Yii::$app->user->identity->username);
        if ($insert) {
            // 评论计数器
            Topic::updateAllCounters(['comment_count' => 1], ['id' => $post->id]);
            // 更新个人总统计
            UserInfo::updateAllCounters(['comment_count' => 1], ['user_id' => $this->user_id]);
        }

        \Yii::$app->cache->set('comment' . $this->id, $this, 0);

    }
}
