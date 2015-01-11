<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "post_meta".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $count
 * @property string $order
 * @property string $created_at
 * @property string $updated_at
 */
class PostMeta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'order', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
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
            'type' => '项目类型',
            'description' => '选项描述',
            'count' => '项目所属内容个数',
            'order' => '项目排序',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
