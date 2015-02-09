<?php

namespace frontend\modules\user\models;

use Yii;
use yii\helpers\Json;
use common\components\db\ActiveRecord;
use common\components\db\Mailer;
use yii\log\Logger;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $avatar
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $tagline
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord
{
    protected $mailer;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'avatar', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['tagline'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'avatar' => '头像',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'tagline' => '一句话介绍',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function create($accountData)
    {
        $account = Json::decode($accountData);

        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $password_hash = Yii::$app->security->generatePasswordHash('123456');
        $auth_key = Yii::$app->security->generateRandomString();
        $time = time();
        $this->setAttributes([
            'username' => $account['login'],
            'avatar' => $account['avatar_url'],
            'password_hash' => $password_hash,
            'auth_key' => $auth_key,
            'password_reset_token' => '',
            'email' => $account['email'],
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        if ($this->save()) {
            // $this->mailer->sendWelcomeMessage($this);
            \Yii::getLogger()->log('User has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating user account', Logger::LEVEL_ERROR);

        return false;
    }
}
