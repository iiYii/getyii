<?php
/**
 * @Author: forecho
 * @Date:   2015-01-30 23:01:28
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-31 21:08:34
 */

namespace frontend\modules\user\models;

use yii\base\Model;

class AvatarForm extends Model
{
    /** @var string */
    public $avatar;

    /** @var User */
    private $_user;

    /** @return User */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = \Yii::$app->user->identity;
        }

        return $this->_user;
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['avatar'], 'required'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'avatar' => '上传头像',
        ];
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save()
    {
        //if ($this->validate()) {
        //    $this->user->username = $this->username;
        //    // 新密码没填写 则为不修改密码
        //    ($this->new_password) ? $this->user->password = $this->new_password : '';
        //    $this->user->tagline = $this->tagline;
        //    return $this->user->save();
        //}

        return false;
    }
}
