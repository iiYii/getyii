<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\components\db\ActiveRecord;

/**
 * This is the model class for table "post_meta".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
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
            [['count', 'order', 'created_at', 'updated_at', 'parent'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['alias', 'type'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
            [['alias'], 'unique']
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
            'parent' => '父级分类',
            'alias' => '变量（别名）',
            'type' => '项目类型',
            'description' => '选项描述',
            'count' => '项目所属内容个数',
            'order' => '项目排序',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public static function blogCategory()
    {

        return ArrayHelper::map(static::find()->where(['type' => 'blog_category'])->all(), 'id', 'name');
    }

    public static function topicCategory()
    {
        $parents = ArrayHelper::map(static::find()->where(['parent' => null])->orWhere(['parent' => 0])->orderBy(['order' => SORT_ASC])->all(), 'id', 'name');
        $nodes = [];
        foreach ($parents as $key => $value) {
            $nodes[$value] = ArrayHelper::map(static::find()->where(['parent' => $key])->asArray()->all(), 'id', 'name');
        }
        return $nodes;
    }

    /**
     * 返回无人区节点id
     * @return mixed|static
     */
    public static function noManLandId()
    {
        $postMeta = self::find()->where(['alias' => 'no-man-land'])->one();
        if ($postMeta) {
            return $postMeta->id;
        }
        return $postMeta;
    }

    public function getParents()
    {
        return ArrayHelper::map(static::find()->where(['parent' => null])->orWhere(['parent' => 0])->all(), 'id', 'name');
    }

    public function getTypes()
    {
        return [
            'topic_category' => '社区分类',
            'blog_category' => '文章分类',
        ];
    }

    public static function topic()
    {
        return ArrayHelper::map(static::find()->where(['type' => 'topic_category'])->all(), 'alias', 'name');
    }
}
