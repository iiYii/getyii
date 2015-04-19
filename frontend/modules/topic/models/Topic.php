<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午5:57
 * description:
 */

namespace frontend\modules\topic\models;


use common\models\Post;

class Topic extends Post
{
    const TYPE = 'topic';

    /**
     * 重写 findOne
     * @inherit
     */
    public static function findOne($condition)
    {
        return static::find()
            ->where('status >= :status', [':status' => self::STATUS_ACTIVE])
            ->andWhere($condition)
            ->one();
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