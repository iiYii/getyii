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
            'id' => 'ID',
            'user_id' => '用户ID',
            'merit_template_id' => '模板ID',
            'type' => '分类',
            'description' => '描述',
            'action_type' => '操作类型 0减去 1新增',
            'increment' => '变化值',
            'created_at' => '创建时间',
            'updated_at' => '创建时间',
        ];
    }
}
