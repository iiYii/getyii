<?php

namespace frontend\modules\user\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_account".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $provider
 * @property string $client_id
 * @property string $data
 * @property string $created_at
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['client_id', 'data'], 'required'],
            [['data'], 'string'],
            [['provider'], 'string', 'max' => 100],
            [['client_id'], 'string', 'max' => 255]
        ];
    }

    public function getIsConnected()
    {
        return $this->user_id != null;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'provider' => '授权提供商',
            'client_id' => 'Client ID',
            'data' => 'Data',
            'created_at' => '创建时间',
        ];
    }
}
