<?php

namespace frontend\modules\tweet\controllers;

use common\components\Controller;
use common\models\Post;
use common\services\NotificationService;
use common\services\TweetService;
use frontend\modules\tweet\models\Tweet;
use frontend\modules\tweet\models\TweetSearch;
use frontend\modules\user\models\UserMeta;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yiier\AutoloadExample;
use yiier\request\ThrottleBehavior;

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
                return $this->redirect('index');
            }
            $model->user_id = Yii::$app->user->id;
            $model->type = $model::TYPE;
            $rawContent = $model->content;
            $model->content = TweetService::replaceTopic(TweetService::replace($rawContent));
            if ($model->save()) {
                (new UserMeta())->saveNewMeta($model->type, $model->id, 'follow');
                (new NotificationService())->newPostNotify(Yii::$app->user->identity, $model, $rawContent);

                $this->flash('发表成功!', 'success');
            }
        }
        return $this->redirect('index');
    }

    /**
     * 伪删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var Tweet $model */
        $model = Tweet::findTweet($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        if ($model->comment_count) {
            $this->flash("已有评论，属于共有财产，不能删除", 'warning');
        } else {
            TweetService::delete($model);
            $this->flash("删除成功。 ", 'success');
        }

        return $this->redirect(['index']);
    }
}
