<?php

namespace common\models;

use common\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "right_link".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $image
 * @property string $content
 * @property integer $type
 * @property string $created_user
 * @property integer $created_at
 * @property integer $updated_at
 */
class RightLink extends ActiveRecord
{
    /**
     * 推荐资源
     */
    const RIGHT_LINK_TYPE_RSOURCES = 1;
    /**
     * 小贴士
     */
    const RIGHT_LINK_TYPE_TIPS = 2;
    /**
     * 友情链接
     */
    const RIGHT_LINK_TYPE_LINKS = 3;
    /**
     * 首页提示语
     */
    const RIGHT_LINK_TYPE_HEADLINE = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%right_link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_user'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
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
            'id' => 'ID',
            'title' => '名称',
            'url' => 'Url',
            'image' => '图片链接',
            'content' => '内容',
            'type' => '展示类别',
            'created_user' => '创建人',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 分类
     * @return array
     */
    public function getTypes()
    {
        return [
            '1' => '推荐资源',
            '2' => '小贴士',
            '3' => '友情链接',
            '4' => '首页提示语',
        ];
    }
}
