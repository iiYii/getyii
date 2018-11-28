<?php

namespace frontend\modules\tweet\controllers;

use common\components\Controller;
use common\models\Post;
use common\services\TweetService;
use frontend\modules\tweet\models\Tweet;
use frontend\modules\tweet\models\TweetSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 默认只能Get方式访问
                    ['allow' => true, 'actions' => ['index'], 'verbs' => ['GET']],
                    // 登录用户POST操作
                    ['allow' => true, 'actions' => ['delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能操作
                    ['allow' => true, 'actions' => ['create'], 'roles' => ['@']],
                ]
            ],
        ]);
    }

    /**
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionIndex()
    {
        $searchModel = new TweetSearch();
        $params = Yii::$app->request->queryParams;
        $params['TweetSearch']['content'] = empty($params['topic']) ? '' : $params['topic'];
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere([
            Post::tableName() . '.type' => Tweet::TYPE,
            'status' => [Post::STATUS_ACTIVE, Post::STATUS_EXCELLENT]
        ]);

        $model = new Tweet();

        if ($time = $model->limitPostTime()) {
            $this->flash("新注册用户只能回帖，{$time}秒之后才能发帖。", 'warning');
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 新建动弹
     * @return mixed
     * @throws \yii\base\ExitException
     */
    public function actionCreate()
    {
        $model = new Tweet();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topService = new TweetService();
            if (!$topService->filterContent($model->content)) {
                $model->addError('content', '请勿发表无意义的内容');
                return $this->redirect('index');
            }
            $model->user_id = Yii::$app->user->id;
            $model->type = $model::TYPE;
            if ($model->save()) {
                $this->flash('发表成功!', 'success');
            }
        }
        if ($model->hasErrors()) {
            $this->flash('发表失败!' . array_values($model->firstErrors)[0], 'error');
        }
        return $this->redirect('index');
    }

    /**
     * 伪删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\ExitException
     */
    public function actionDelete($id)
    {
        /** @var Tweet $model */
        $model = Tweet::findTweet($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        if ($model->comment_count) {
            $model->addError('content', '已有回复，属于共有财产，不能删除');
        } else {
            TweetService::delete($model);
            $this->flash("删除成功。 ", 'success');
        }

        return $this->redirect(['index']);
    }
}
