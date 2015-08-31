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
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'type' => Yii::t('common', 'Type'),
            'merit' => Yii::t('common', 'Merit'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
