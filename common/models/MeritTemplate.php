<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "merit_template".
 *
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property string $action
 * @property integer $action_type
 * @property integer $increment
 * @property integer $created_at
 * @property integer $updated_at
 */
class MeritTemplate extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merit_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'description', 'action'], 'required'],
            [['action_type', 'increment', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 20],
            [['description', 'action'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '分类',
            'description' => '描述',
            'action' => '具体操作的action',
            'action_type' => '操作类型 0减去 1新增',
            'increment' => '变化值',
            'created_at' => '创建时间',
            'updated_at' => '创建时间',
        ];
    }
}
