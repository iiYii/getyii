<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Course;

/**
 * CourseSearch represents the model behind the search form about `common\Models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return parent::rules();
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $conditions=[])
    {
        // $query = Post::find()->where($conditions);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => [
        //        'pageSize' => 20,
        //     ],
        //     'sort'=> ['defaultOrder' => [
        //        'order' => SORT_ASC,
        //        'created_at' => SORT_DESC,
        //     ]]
        // ]);

        // if (!($this->load($params) && $this->validate())) {
        //     return $dataProvider;
        // }

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'post_meta_id' => $this->post_meta_id,
        //     'user_id' => $this->user_id,
        //     'view_count' => $this->view_count,
        //     'comment_count' => $this->comment_count,
        //     'favorite_count' => $this->favorite_count,
        //     'like_count' => $this->like_count,
        //     'thanks_count' => $this->thanks_count,
        //     'hate_count' => $this->hate_count,
        //     'status' => $this->status,
        //     'order' => $this->order,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ]);

        // $query->andFilterWhere(['like', 'type', $this->type])
        //     ->andFilterWhere(['like', 'title', $this->title])
        //     ->andFilterWhere(['like', 'author', $this->author])
        //     ->andFilterWhere(['like', 'excerpt', $this->excerpt])
        //     ->andFilterWhere(['like', 'image', $this->image])
        //     ->andFilterWhere(['like', 'content', $this->content])
        //     ->andFilterWhere(['like', 'tags', $this->tags]);

        // return $dataProvider;

        $query = Course::find()->where($conditions);

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 3,
                ],
                // 'sort' => ['defaultOrder' =>[
                //     'order' => SORT_ASC,
                //     'created_at' => SORT_DESC
                // ]],
            ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }

        $query->andFilterWhere([
                'id' => $this->id,
                'create_at' => $this->create_at,
                'update_at' => $this->update_at,
                'user_id'   => $this->user_id,
                'title'     => $this->title,
                'conent'    => $this->content
            ]);

        return $dataProvider;
    }
}
