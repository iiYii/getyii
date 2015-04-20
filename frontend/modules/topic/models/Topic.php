<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午5:57
 * description:
 */

namespace frontend\modules\topic\models;


use common\models\Post;
use common\models\PostTag;
use frontend\modules\user\models\UserMeta;
use yii\web\NotFoundHttpException;

class Topic extends Post
{
    const TYPE = 'topic';

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
     * 通过ID获取指定话题
     * @param $id
     * @return array|null|\yii\db\ActiveRecord|static
     * @throws NotFoundHttpException
     */
    public static function findTopic($id)
    {
        $model = static::find()
            ->where('status >= :status', [':status' => self::STATUS_ACTIVE])
            ->andWhere(['id' => $id, 'type' => 'topic'])
            ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 获取已经删除过的话题
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function findDeletedTopic($id)
    {
        $model = static::find()
            ->where(['id' => $id, 'status' => self::STATUS_DELETED, 'type' => 'topic'])
            ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
                    'name'  => $tag,
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