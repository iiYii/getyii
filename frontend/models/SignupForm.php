<?php
namespace frontend\models;

use common\models\User;
use common\models\UserInfo;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            // 启用事物
            $transaction=\Yii::$app->db->beginTransaction();
                $user = new User();
                $user->username = $this->username;
                $user->email = $this->email;
                $user->setPassword($this->password);
                $user->generateAuthKey();
                $return = $user->save();

                // 添加用户信息
                $userInfo = new UserInfo();
                $userInfo->user_id = $user->id;
                $userInfo->prev_login_time = time();
                $userInfo->prev_login_ip = Yii::$app->getRequest()->getUserIP();
                $userInfo->last_login_time = time();
                $userInfo->last_login_ip = Yii::$app->getRequest()->getUserIP();
                $userInfo->created_at = time();
                $userInfo->updated_at = time();
                $return = $userInfo->save();
            if(!$return){
                $transaction->rollback();
            }else{
                $transaction->commit();
            }
            return $user;
        }

        return null;
    }
}
