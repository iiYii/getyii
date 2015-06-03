<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "course_terms".
 *
 * @property integer $id
 * @property string $title
 * @property integer $create_at
 * @property integer $update_at
 * @property string $excerpt
 * @property integer $parent_id
 */
class CourseTerms extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_terms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'required'],
            [['create_at', 'update_at', 'parent_id'], 'integer'],
            [['title', 'excerpt'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'excerpt' => '简介',
            'parent_id' => '父级id',
        ];
    }
}
