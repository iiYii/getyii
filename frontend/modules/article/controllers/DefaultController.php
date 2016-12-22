<?php

namespace frontend\modules\article\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Post;
use common\models\PostMeta;
use backend\models\PostSearch;
use common\models\PostComment;
use frontend\modules\article\models\Article;
use common\services\ArticleService;
use common\components\Controller;
use frontend\modules\user\models\Donate;

/**
 * DefaultController implements the CRUD actions for Article model.
 */
class DefaultController extends Controller
{

    const PAGE_SIZE = 50;
    public $sorts = [
        'newest' => '最新的',
        'excellent' => '优质主题',
        'hotest' => '热门的',
        'uncommented' => '未回答的'
    ];
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();

        // 话题或者分类筛选
        $params = Yii::$app->request->queryParams;
        if (isset($params['node'])) {
            $postMeta = PostMeta::findOne(['alias' => $params['node']]);
            ($postMeta) ? $params['PostSearch']['post_meta_id'] = $postMeta->id : '';
        }

        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere([Post::tableName() . '.type' => 'article', Post::tableName().'.status' => [Post::STATUS_ACTIVE, Post::STATUS_EXCELLENT]]);
        $dataProvider->pagination->pageSize=20;
        // 排序
        $sort = $dataProvider->getSort();
        $sort->attributes = array_merge($sort->attributes, [
            'hotest' => [
                'asc' => [
                    'comment_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ],
            ],
            'excellent' => [
                'asc' => [
                    'status' => SORT_DESC,
                    'comment_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ],
            ],
            'uncommented' => [
                'asc' => [
                    'comment_count' => SORT_ASC,
                    'created_at' => SORT_DESC
                ],
            ]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'sorts' => $this->sorts,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 文章浏览页面
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Article::findArticle($id);

        //登录才能访问的节点内容
        $MetaId = $model->post_meta_id;
        $node = PostMeta::findOne(['id'=>$MetaId]);

        $dataProvider = new ActiveDataProvider([
            'query' => PostComment::findCommentList($id),
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]]
        ]);

        // 文章浏览次数
        Article::updateAllCounters(['view_count' => 1], ['id' => $id]);

        $user = Yii::$app->user->identity;
        $admin = ($user && ($user->isAdmin($user->username) || $user->isSuperAdmin($user->username))) ? true : false;

        //内容页面打赏
        if (in_array($node->alias, params('donateNode'))) {
            $donate = Donate::findOne(['user_id' => Article::findOne(['id' => request()->get('id')])->user_id, 'status' => Donate::STATUS_ACTIVE]);
        }

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'comment' => new PostComment(),
            'admin' => $admin,
            'donate' => isset($donate) ? $donate : [],
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * 发布新文章
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topService = new ArticleService();
            if (!$topService->filterContent($model->title) || !$topService->filterContent($model->content)) {
                $this->flash('请勿发表无意义的内容', 'warning');
                return $this->redirect('create');
            }

            if ($model->save()) {
                $this->flash('发表文章成功!', 'success');
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
