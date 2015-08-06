<?php

namespace frontend\modules\tweet\controllers;

use common\components\Controller;
use common\models\Post;
use common\models\PostSearch;
use common\services\TweetService;
use frontend\modules\tweet\models\Tweet;
use frontend\modules\user\models\UserMeta;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere([
            Post::tableName() . '.type' => Tweet::TYPE,
            'status'=>[Post::STATUS_ACTIVE, Post::STATUS_EXCELLENT]
        ]);

        $model = new Tweet();

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 新建动弹
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tweet();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topService = new TweetService();
            if (!$topService->filterContent($model->content)) {
                $this->flash('请勿发表无意义的内容', 'warning');
            }
            $model->user_id = Yii::$app->user->id;
            $model->type = $model::TYPE;
            if ($model->save()) {
                (new UserMeta())->saveNewMeta($model->type, $model->id, 'follow');
                $this->flash('发表成功!', 'success');
            }
        }
        return $this->redirect('index');
    }
}
