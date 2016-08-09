<?php
/**
 * @Author: forecho
 * @Date:   2015-01-30 23:01:28
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-31 21:08:34
 */

namespace frontend\modules\user\models;

use yii\base\Model;
use yii\web\UploadedFile;

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
            [['avatar'], 'file', 'extensions' => 'gif, jpg, png', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => \Yii::t('app', 'File has to be smaller than 2MB')],
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
        return isset($this->user->avatar) ? \Yii::$app->basePath . \Yii::$app->params['avatarPath'] . $this->user->avatar : null;
    }


    /**
     * fetch new generated image file name with complete path
     * @return string
     */
    public function getNewUploadedImageFile()
    {
        return isset($this->avatar) ? \Yii::$app->basePath . \Yii::$app->params['avatarPath'] . $this->avatar : null;
    }

    /**
     * use a default icon in case of errors while processing uploaded files
     */
    public function useDefaultImage()
    {
        $identicon = new \Identicon\Identicon();
        $this->avatar = $identicon->getImageDataUri($this->user->email);
    }

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function uploadImage()
    {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'avatar');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // generate a unique file name
        $this->avatar = \Yii::$app->security->generateRandomString() . ".{$image->extension}";

        // the uploaded image instance
        return $image;
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
        // 删除缓存的旧头像
        $avatarCachePath = \Yii::$app->basePath . \Yii::$app->params['avatarCachePath'];
        $files = glob("{$avatarCachePath}/*_{$this->user->avatar}");
        array_walk($files, function ($file) {
            unlink($file);
        });

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }


        // if deletion successful, reset your file attributes
        $this->avatar = null;

        return true;
    }
}
