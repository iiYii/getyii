<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "post_tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $count
 * @property string $created_at
 */
class PostTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'count' => '计数',
            'created_at' => '创建时间',
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
