<?php

namespace common\models;

use yii\data\ActiveDataProvider;

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
    public function search($keyword)
    {
        $query = self::find()->where($keyword)->andWhere(['status' => [1, 2]]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ]
            ]
        ]);

        return $dataProvider;
    }
}