<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "merit_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $merit_template_id
 * @property string $type
 * @property string $description
 * @property integer $action_type
 * @property integer $increment
 * @property integer $created_at
 * @property integer $updated_at
 */
class MeritLog extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merit_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'merit_template_id', 'action_type', 'increment', 'created_at', 'updated_at'], 'integer'],
            [['type', 'description'], 'required'],
            [['type'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'merit_template_id' => Yii::t('common', 'Merit Template ID'),
            'type' => Yii::t('common', 'Type'),
            'description' => Yii::t('common', 'Description'),
            'action_type' => Yii::t('common', 'Action Type'),
            'increment' => Yii::t('common', 'Increment'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
