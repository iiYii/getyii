<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午4:10
 * description:
 */

namespace frontend\modules\user\models;


use common\models\User;
use common\models\Post;
use frontend\modules\topic\models\Topic;

class Hate extends UserMeta
{
    const TYPE = 'hate';

    /**
     * 喜欢数据切换
     * @param User $user
     * @param Post $model
     * @return array
     */
    protected static function toggleType(User $user, Post $model)
    {
        $data = [
            'target_id' => $model->id,
            'target_type' => $model::TYPE,
            'user_id' => $user->id
        ];
        if (!self::deleteAll($data + ['type' => self::TYPE])) { // 删除数据有行数则代表有数据,无行数则添加数据
            $like = new static();
            $like->setAttributes($data);
            $result = $like->save();
            if ($result) { // 如果是新增数据, 删除掉Hate的同类型数据
                $attributes = [
                    'like_count' => 1
                ];
                if (Hate::deleteAll($data + ['type' => Hate::TYPE])) { // 如果有删除hate数据, hate_count也要-1
                    $attributes['hate_count'] = -1;
                }
                $model->updateCounters($attributes);
            }
            return [$result, $like];
        }
        $model->updateCounters([
            'like_count' => -1
        ]);
        return [true, null];
    }

    /**
     * 赞问题(如果已经赞,则取消赞)
     * @param User $user
     * @param Topic $topic
     * @return array
     */
    public static function topic(User $user, Topic $topic)
    {
        return static::toggleType($user, $topic);
    }


    /**
     * 赞回答(如果已经赞,则取消赞)
     * @param User $user
     * @param PostComment $comment
     * @return array
     */
    public static function comment(User $user, PostComment $comment)
    {
        return static::toggleType($user, $comment);
    }
}