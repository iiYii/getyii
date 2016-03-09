<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\Session;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('common', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('common', 'Username'),
            'password' => Yii::t('common', 'Password'),
            'rememberMe' => Yii::t('common', 'Remember Me'),
        ];
    }

    /**
     * email 邮箱登录
     * @user onyony
     * @return bool|null|static
     */
    public function getUser()
    {
        if ($this->_user === false) {
            if (strpos($this->username, "@"))
                $this->_user = User::findByEmail($this->username); //email 登录
            else
                $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * 登陆之后更新用户资料
     * @return bool
     */
    public function updateUserInfo()
    {
        /** @var UserInfo $model */
        $model = UserInfo::findOne(['user_id' => Yii::$app->user->getId()]);
        $model->login_count += 1;
        $model->prev_login_time = $model->last_login_time;
        $model->prev_login_ip = $model->last_login_ip;
        $model->last_login_time = time();
        $model->last_login_ip = Yii::$app->getRequest()->getUserIP();

        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }
        $model->session_id = Yii::$app->session->id;
        Yii::$app->session->close();

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function loginAdmin()
    {
        if ($this->validate()) {
            if (User::isSuperAdmin($this->username)) {
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
            $this->addError('username', 'You don\'t have permission to login.');
        } else {
            $this->addError('password', Yii::t('common', 'Incorrect username or password.'));
        }
        return false;
    }
}
