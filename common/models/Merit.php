<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "merit".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $merit
 * @property integer $created_at
 * @property integer $updated_at
 */
class Merit extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'merit', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'required'],
            [['type'], 'string', 'max' => 20]
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
            'type' => '分类',
            'merit' => '总值',
            'created_at' => '创建时间',
            'updated_at' => '创建时间',
        ];
    }
}
