<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nav_url".
 *
 * @property integer $id
 * @property integer $nav_id
 * @property string $title
 * @property string $url
 * @property string $description
 * @property integer $order
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class NavUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nav_url}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nav_id', 'order'], 'integer'],
            [['title', 'url', 'nav_id','order'], 'required'],
            [['title', 'description'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nav_id' => Yii::t('app', 'Nav ID'),
            'title' => Yii::t('app', 'Title'),
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'order' => Yii::t('app', 'Order'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


}
