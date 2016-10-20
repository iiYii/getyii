<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manual".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $description
 * @property string $cover
 * @property integer $sort_order
 * @property string $view_count
 * @property string $status
 * @property integer $user_id
 * @property string $create_time
 * @property string $update_time
 */
class Manual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['sort_order', 'view_count', 'user_id', 'create_time', 'update_time'], 'integer'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['description', 'cover'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'cover' => Yii::t('app', 'Cover'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'view_count' => Yii::t('app', 'View Count'),
            'status' => Yii::t('app', 'Status'),
            'user_id' => Yii::t('app', 'User ID'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return ManualQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ManualQuery(get_called_class());
    }

    public static function getAll()
    {
        $data_array = ArrayHelper::map(static::find()->orderBy(['sort_order' => SORT_ASC])->all(), 'id', 'title');
        return $data_array;
    }
}
