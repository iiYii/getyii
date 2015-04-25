<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rightlink".
 *
 * @property integer $rlid
 * @property string $title
 * @property string $url
 * @property string $image
 * @property string $content
 * @property integer $class
 * @property string $created_user
 * @property string $created_at
 * @property string $updated_at
 */
class Rightlink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rightlink';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_user'], 'required'],
            [['class'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'image', 'content'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 225],
            [['created_user'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rlid' => 'Rlid',
            'title' => '名称',
            'url' => 'Url',
            'image' => '图片链接',
            'content' => '内容',
            'class' => '展示类别',
            'created_user' => '创建人',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * 
     * 
     */
    public function getTypes()
    {
        return [
            '1' => '推荐资源',
            '2' => '小贴士',
        ];
    }
    
}
