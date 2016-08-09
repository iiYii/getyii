<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "post_tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $count
 * @property string $created_at
 * @property integer $updated_at
 */
class PostTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'count' => '计数',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
