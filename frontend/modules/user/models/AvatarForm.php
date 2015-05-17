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
            [['avatar'], 'file', 'extensions' => 'gif, jpg, png'],
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
        if ($this->validate()) {
            $this->user->avatar = $this->avatar;
            return $this->user->save();
        }
        return false;
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getImageFile()
    {
        return isset($this->user->avatar) ? \Yii::$app->params['avatarPath'] . $this->user->avatar : null;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage()
    {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;

        return true;
    }
}
