<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午5:57
 * description:
 */

namespace frontend\modules\topic\models;


use common\models\Post;
use common\models\PostTag;
use common\models\Search;
use common\services\TopicService;
use frontend\modules\user\models\UserMeta;
use yii\web\NotFoundHttpException;
use Yii;

class Topic extends Post
{
    const TYPE = 'topic';

    /**
     * @var boolean CC 协议
     */
    public $cc;

    public function getLike()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'like', $this->id);
    }

    public function getFollow()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'follow', $this->id);
    }

    public function getHate()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'hate', $this->id);
    }

    public function getFavorite()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'favorite', $this->id);
    }

    public function getThanks()
    {
        $model = new UserMeta();
        return $model->isUserAction(self::TYPE, 'thanks', $this->id);
    }

    /**
     * 获取关注者
     * @return static
     */
    public function getFollower()
    {
        return $this->hasMany(UserMeta::className(), ['target_id' => 'id'])
            ->where(['target_type' => self::TYPE, 'type' => 'follow']);
    }

    /**
     * 通过ID获取指定话题
     * @param $id
     * @param string $condition
     * @return array|null|\yii\db\ActiveRecord|static
     * @throws NotFoundHttpException
     */
    public static function findModel($id, $condition = '')
    {
//        if (!($model = Yii::$app->cache->get('topic' . $id))) {
        $model = static::find()
            ->where($condition)
            ->andWhere(['id' => $id, 'type' => self::TYPE])
            ->one();
//        }
        if ($model) {
//            Yii::$app->cache->set('topic' . $id, $model, 0);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * 通过ID获取指定话题
     * @param $id
     * @return array|Topic|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function findTopic($id)
    {
        return static::findModel($id, ['>=', 'status', self::STATUS_ACTIVE]);
    }

    /**
     * 获取已经删除过的话题
     * @param $id
     * @return array|Topic|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function findDeletedTopic($id)
    {
        return static::findModel($id, ['>=', 'status', self::STATUS_DELETED]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->tags) {
                $this->addTags(explode(',', $this->tags));
            }
            $this->content = TopicService::replace($this->content)
                . ($this->cc ? t('app', 'cc {username}', ['username' => Yii::$app->user->identity->username]) : '');

            if ($insert) {
                $this->user_id = (($this->user_id) ?: Yii::$app->user->id);
                $this->type = self::TYPE;
                $this->last_comment_time = $this->created_at;
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (isset(Yii::$app->params['setting']) && Yii::$app->params['setting']['xunsearch']) {
            if ($insert) {
                $search = new Search();
                $search->topic_id = $this->id;
                $search->status = self::STATUS_ACTIVE;
            } else {
                $search = Search::findOne($this->id);
                if (!$search) {
                    // 如果立即修改 会因为在 xunsearch 找不到而不能 save
                    return false;
                }
                $search->status = $this->status;
            }
            $search->title = $this->title;
            $search->content = $this->content;
            $search->updated_at = $this->updated_at;
            $search->save();
        }
    }

    /**
     * 最后回复更新
     * @param string $username
     * @return bool
     */
    public function lastCommentToUpdate($username = '')
    {
        $this->setAttributes([
            'last_comment_username' => $username,
            'last_comment_time' => time()
        ]);
        return $this->save();
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