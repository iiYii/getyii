<?php

namespace common\models;

use Yii;
use common\components\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use common\models\CourseTerms;
use yii\base\Model;
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
class CourseTermsSearch extends CourseTerms
{
   
    /**
    *   得到所有顶级分类
    */
    public function getParents(){
        return ArrayHelper::map(static::find()->where(['parent_id' => null])->all(), 'id', 'name');
    }

        public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = CourseTerms::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $this->load($params);
        
        if(!$this->validate()){
            return $dataProvider;
        }
        
        $query->addFilterWhere();
        
        return $dataProvider;
    }

}
