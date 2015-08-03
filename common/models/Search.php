<?php

namespace common\models;

use yii\data\ActiveDataProvider;

class Search extends \hightman\xunsearch\ActiveRecord
{
    public function search($keyword)
    {
        $query = self::find()->where($keyword)->andWhere(['status' => [1, 2]]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}