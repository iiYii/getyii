<?php
namespace common\models;

use common\helpers\Avatar;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;
use yiier\merit\models\Merit;
use frontend\modules\user\models\UserAccount;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $avatar
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $tagline
 * @property string $password write-only password
 *
 * @property string $userAvatar
 * @property Merit $merit
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    const ROLE_ADMIN = 20;
    const ROLE_SUPER_ADMIN = 30;

    use \DevGroup\TagDependencyHelper\TagDependencyTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'CacheableActiveRecord' => [
                'class' => \DevGroup\TagDependencyHelper\CacheableActiveRecord::className(),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['role', 'default', 'value' => 10],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * 邮箱登录
     * @user onyony
     * @param $email
     * @return null|static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * 获取用户头像
     * @param int $size
     * @return string
     * @throws \yii\base\Exception
     */
    public function getUserAvatar($size = 50)
    {
        if ($this->avatar) {
            // TODO 写法更优雅
            $avatarPath = Yii::$app->basePath . Yii::$app->params['avatarPath'];
            $avatarCachePath = Yii::$app->basePath . Yii::$app->params['avatarCachePath'];
            FileHelper::createDirectory($avatarCachePath); // 创建文件夹
            if (file_exists($avatarCachePath . $size . '_' . $this->avatar)) {
                // 缓存头像是否存在
                return Yii::$app->params['avatarCacheUrl'] . $size . '_' . $this->avatar;
            }
            if (file_exists($avatarPath . $this->avatar)) {
                // 原始头像是否存在
                \yii\imagine\Image::thumbnail($avatarPath . $this->avatar, $size, $size)
                    ->save($avatarCachePath . $size . '_' . $this->avatar, ['quality' => 100]);
                return Yii::$app->params['avatarCacheUrl'] . $size . '_' . $this->avatar;
            }
        }
        return (new Avatar($this->email, $size))->getAvater();
    }

    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }

    public function getMerit()
    {
        return $this->hasOne(Merit::className(), ['user_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getAccounts()
    {
        $connected = [];
        $accounts = $this->hasMany(UserAccount::className(), ['user_id' => 'id'])->all();

        // @var Account $account
        foreach ($accounts as $account) {
            $connected[$account->provider] = $account;
        }

        return $connected;
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $time = time();
            $ip = isset(Yii::$app->request->userIP) ? Yii::$app->request->userIP : '127.0.0.1';
            $userInfo = Yii::createObject([
                'class' => UserInfo::className(),
                'user_id' => $this->id,
                'prev_login_time' => $time,
                'prev_login_ip' => $ip,
                'last_login_time' => $time,
                'last_login_ip' => $ip,
                'created_at' => $time,
                'updated_at' => $time,
            ]);
            $userInfo->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }


    public static function isAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_ADMIN])) {
            return true;
        } else {
            return false;
        }
    }

    public static function isSuperAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_SUPER_ADMIN])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取权限
     * @param $username
     * @return bool
     */
    public static function getThrones($username = '')
    {
        if (!$username && Yii::$app->user->id) {
            $username = Yii::$app->user->identity->username;
        } else {
            return false;
        }
        if ($isAdmin = self::isAdmin($username)) {
            return $isAdmin;
        }
        return self::isSuperAdmin($username);
    }

    public static function getRole($role)
    {
        $data = [
            self::ROLE_ADMIN => [
                'name' => '高级会员',
                'color' => 'primary',
            ],
            self::ROLE_USER => [
                'name' => '会员',
                'color' => 'info',
            ],
            self::ROLE_SUPER_ADMIN => [
                'name' => '管理员',
                'color' => 'success',
            ]
        ];
        return $data[$role];
    }

    public static function getRoleList()
    {
        return [
            self::ROLE_ADMIN => '高级会员',
            self::ROLE_USER => '会员',
            self::ROLE_SUPER_ADMIN => '管理员',
        ];
    }

    public static function getStatus($status)
    {
        $data = [
            self::STATUS_DELETED => [
                'name' => '已删除',
                'color' => 'danger',
            ],
            self::STATUS_ACTIVE => [
                'name' => '正常',
                'color' => 'default',
            ],
        ];

        return $data[$status];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_DELETED => '已删除',
            self::STATUS_ACTIVE => '正常',
        ];
    }
}
