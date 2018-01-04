<?php

namespace common\models;


/**
 * This is the model class for table "topic".
 *
 * @property integer $topic_id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $updated_at
 */
class Search extends \hightman\xunsearch\ActiveRecord
{
    public static function search($keyword)
    {
        return self::find()->where($keyword)->andWhere(['status' => [1, 2]])
                ->asArray()
                ->offset(0)
                ->limit(1000)
                ->all();
    }
}
