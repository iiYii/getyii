<?php

namespace frontend\controllers;

use Yii;
use common\models\Post;
use yii\filters\AccessControl;
use common\models\PostSearch;
use common\models\PostComment;
use common\models\PostMeta;
use common\models\UserMeta;
use common\models\UserInfo;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * TopicController implements the CRUD actions for Post model.
 */
class TopicController extends Controller
{
    public function behaviors()
    {
        return [
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
                    ['allow' => true, 'actions' => ['view', 'index'], 'verbs' => ['GET']],
                    // 登录用户才能提交评论或其他内容
                    ['allow' => true, 'actions' => ['api', 'view', 'delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能使用API操作(赞,踩,收藏)
                    ['allow' => true, 'actions' => ['create', 'update', 'revoke'], 'roles' => ['@']],
                ]
            ]
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $params = Yii::$app->request->queryParams;
        $params['PostSearch']['type'] = 'topic';
        $params['PostSearch']['status'] = 1;
        // 话题筛选
        if (isset($params['tag']) && $params['tag'] != 'index') {
            $postMeta = PostMeta::findOne(['alias' => $params['tag']]);
            $params['PostSearch']['post_meta_id'] = $postMeta->id;
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $comment = $this->newComment($model);
        $dataProvider = new ActiveDataProvider([
            'query' => PostComment::find()->where(['post_id' => $id]),
        ]);

        // 文章浏览次数
        Post::updateAllCounters(['view_count' =>1], ['id' => $id]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'comment' => $comment,
            'isCurrent' => $model->getIsCurrent(),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->type = 'topic';
            if ($model->tags = Yii::$app->request->post('tags')) {
                $model->addTags(explode(',', $model->tags));
            }
            if ($model->save()) {
                // 更新个人总统计
                UserInfo::updateAllCounters(['post_count' =>1], ['user_id' => $model->user_id]);
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
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model === null || !$model->getIsCurrent()) {
            throw new NotFoundHttpException;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->tags = Yii::$app->request->post('tags');
            $model->addTags(explode(',', $model->tags));
            if ($model->save()) {
                $this->flash('发表更新成功!', 'success');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 伪删除
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->updateCounters(['status' => 1]);
        $revoke = Html::a('撤消',['/topic/revoke', 'id' => $model->id]);
        $this->flash("「{$model->title}」文章删除成功。 反悔了？{$revoke}", 'success');
        return $this->redirect(['index']);
    }

    /**
     * 撤消删除
     * @param integer $id
     * @return mixed
     */
    public function actionRevoke($id)
    {
        $model = $this->findModel($id, 2);
        $model->updateCounters(['status' => -1]);
        $this->flash("「{$model->title}」文章撤销删除成功。", 'success');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * 创建新回答
     * @param $question
     * @return PostComment
     */
    protected function newComment(Post $post)
    {
        $model = new PostComment();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->post_id = $post->id;
            $model->ip = Yii::$app->getRequest()->getUserIP();
            if ($model ->save()) {
                // 评论计数器
                Post::updateAllCounters(['comment_count' =>1], ['id' => $post->id]);
                // 更新个人总统计
                UserInfo::updateAllCounters(['comment_count' =>1], ['user_id' => $model->user_id]);
                return $this->message('回答发表成功!', 'success', $this->refresh(), 'flash');
            }
        }
        return $model;
    }

    /**
     * 收藏, 赞, 踩, 标签 接口
     * @param $id
     * @return json
     */
    public function actionApi()
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id = $request->post('id'));
        if ($model === null || $model->getIsCurrent()) {
            return $this->message('错误的操作', 'error');
        }
        $opeartions = ['like', 'thanks', 'favorite', 'hate'];
        if (!in_array($type = $request->post('do'), $opeartions)) {
            return $this->message('错误的操作', 'error');
        }
        $userMeta = new UserMeta();
        $result = $userMeta->userAction($type, $id);
        if ($result !== true) {
            return $this->message($result === false ? '操作失败' : $result, 'error');
        }
        return $this->message('操作成功', 'success');
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $status
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $status=1)
    {
        if (($model = Post::findOne(['id' => $id, 'status' => $status, 'type' => 'topic'])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}