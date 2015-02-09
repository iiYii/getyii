<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_auth".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $type
 * @property string $token
 * @property string $openid
 * @property string $created_at
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'openid'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['token', 'openid'], 'string', 'max' => 255]
        ];
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
            'type' => '联合登录类型',
            'token' => 'Token',
            'openid' => 'Openid',
            'created_at' => '创建时间',
        ];
    }
}
