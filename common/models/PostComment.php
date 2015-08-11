<?php

namespace common\models;

use common\services\NotificationService;
use frontend\modules\user\models\UserMeta;
use Yii;
use common\components\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

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
            [['comment'], 'string', 'min' => 1],
            [['ip'], 'string', 'max' => 255]
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        Yii::$app->cache->set('comment' . $this->id, $this, 0);
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
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->where(['type' => 'topic']);
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
    public function findModel($id, $condition = '')
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
     * @return static
     */
    public static function findCommentList($postId)
    {
        return static::find()->where(['post_id' => $postId]);
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
     * 分别转换@用户和#楼层
     * @param $comment
     * @return mixed
     */
    public function replace($comment)
    {
        preg_match_all("/\#(\d*)/i", $comment, $floor);
        if (isset($floor[1])) {
            foreach ($floor[1] as $key => $value) {
                $search = "#{$value}楼";
                $place = "[{$search}](#comment{$value}) ";
                $comment = str_replace($search . ' ', $place, $comment);
            }
        }

        $users = $this->parse($comment);
        foreach ($users as $key => $value) {
            $search = '@' . $value;
            $url = Url::to(['/user/default/show', 'username' => $value]);
            $place = "[{$search}]({$url}) ";
            $comment = str_replace($search . ' ', $place, $comment);
        }

        return $comment;
    }

    public function parse($comment)
    {
        preg_match_all("/(\S*)\@([^\r\n\s]*)/i", $comment, $atlistTmp);
        $users = [];
        foreach ($atlistTmp[2] as $key => $value) {
            if ($atlistTmp[1][$key] || strlen($value) > 25) {
                continue;
            }
            $users[] = $value;
        }
        return ArrayHelper::map(User::find()->where(['username' => $users])->all(), 'id', 'username');
    }

    /**
     * @inheritdoc
     */
    public
    function attributeLabels()
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
