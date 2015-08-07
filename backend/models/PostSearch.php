<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `common\Models\Post`.
 */
class PostSearch extends Post
{
    public $category_name;
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_meta_id', 'user_id', 'view_count', 'comment_count', 'favorite_count', 'like_count', 'thanks_count', 'hate_count', 'status', 'order', 'created_at', 'updated_at'], 'integer'],
            [['type', 'title', 'author', 'excerpt', 'image', 'content', 'tags', 'category_name', 'username'], 'safe'],
        ];
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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find()->joinWith(['category', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => [
                'order' => SORT_ASC,
                'updated_at' => SORT_DESC,
            ]]
        ]);

        $dataProvider->sort->attributes['category_name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['username' => SORT_ASC],
            'desc' => ['username' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'post_meta_id' => $this->post_meta_id,
            'user_id' => $this->user_id,
            'view_count' => $this->view_count,
            'comment_count' => $this->comment_count,
            'favorite_count' => $this->favorite_count,
            'like_count' => $this->like_count,
            'thanks_count' => $this->thanks_count,
            'hate_count' => $this->hate_count,
            Post::tableName() . '.status' => $this->status,
            'order' => $this->order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', Post::tableName() . '.type', $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'excerpt', $this->excerpt])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'name', $this->category_name])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
