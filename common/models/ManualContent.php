<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manual_content".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $manual_id
 * @property string $title
 * @property string $content
 * @property string $name
 * @property string $link
 * @property integer $sort_order
 * @property string $view_count
 * @property string $status
 * @property string $create_time
 * @property string $update_time
 */
class ManualContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manual_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'manual_id', 'sort_order', 'view_count', 'create_time', 'update_time'], 'integer'],
            [['title', 'content', 'name'], 'required'],
            [['content', 'status'], 'string'],
            [['title', 'link'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'manual_id' => Yii::t('app', 'Manual ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
            'link' => Yii::t('app', 'Link'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'view_count' => Yii::t('app', 'View Count'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->update_time = time();
            } else {
                $this->update_time = time();
            }
            return true;
        } else
            return false;
    }

    public static function getParentNameById($parent_id){
        $result = static::find()->where(['id'=>$parent_id])->one();
        if($result){
            return $result->name;
        }
        else{
            return false;
        }
    }

    public static function getAll(){
        return ArrayHelper::map(array_merge(static::find()->select(['id','title'])->where(['status'=>'Y','parent_id'=>0])->orderBy('sort_order ASC')->asArray()->all()), 'id', 'title');
    }
}
