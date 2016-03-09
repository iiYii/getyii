<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "nav".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $order
 * @property string $created_at
 * @property string $updated_at
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nav}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','alias','order'], 'required'],
            [['order'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function getNavList()
    {
        $data_array = ArrayHelper::map(static::find()->orderBy(['order' => SORT_ASC])->all(), 'id', 'name');
        return $data_array;
    }

}
