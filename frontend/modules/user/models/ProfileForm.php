<?php
namespace frontend\modules\user\models;

use Yii;
use yii\base\Model;

/**
 * User Profile Form
 */
class ProfileForm extends Model
{
    public $username;
    public $email;
    public $info;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '用户名已经存在'],
            [['username', 'info'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'email' => '邮箱',
            'info' => '个人简介',
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
