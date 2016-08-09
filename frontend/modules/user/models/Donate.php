<?php

namespace frontend\modules\user\models;

use common\components\db\ActiveRecord;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%donate}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string $description
 * @property string $qr_code
 * @property integer $created_at
 * @property integer $updated_at
 */
class Donate extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%donate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            ['qr_code', 'required', 'on' => 'create'],
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['qr_code'], 'file', 'extensions' => 'gif, jpg, png', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => \Yii::t('app', 'File has to be smaller than 2MB')],
            [['description', 'qr_code'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'description' => Yii::t('app', 'Description'),
            'qr_code' => Yii::t('app', 'Qr Code'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
        $image = UploadedFile::getInstance($this, 'qr_code');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // generate a unique file name
        $this->qr_code = \Yii::$app->security->generateRandomString() . ".{$image->extension}";
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
        if (!isset($this->oldAttributes['qr_code']) || !$this->oldAttributes['qr_code']) {
            return false;
        }

        $file = \Yii::$app->basePath . \Yii::$app->params['qrCodePath'] . $this->oldAttributes['qr_code'];
        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        return true;
    }

    public static function getStatuses()
    {
        return [
            1 => '开启',
            0 => '停用',
        ];
    }
}
