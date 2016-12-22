<?php

namespace frontend\modules\article\controllers;

use common\models\UserInfo;
use common\services\NotificationService;
use common\services\ArticleService;
use frontend\models\Notification;
use frontend\modules\article\models\Article;
use frontend\modules\user\models\UserMeta;
use Yii;
use common\models\PostComment;
use common\components\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for PostComment model.
 */
class CommentController extends Controller
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
                    // 登录用户POST操作
                    ['allow' => true, 'actions' => ['delete'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能操作
                    ['allow' => true, 'actions' => ['create', 'update'], 'roles' => ['@']],
                ]
            ],
        ]);
    }

    /**
     * 创建评论
     * @param $id
     * @return PostComment|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new PostComment();
        if ($model->load(Yii::$app->request->post())) {
            $Service = new ArticleService();
            if (!$Service->filterContent($model->comment)) {
                $this->flash('回复内容请勿回复无意义的内容，如你想收藏或赞等功能，请直接操作这篇帖子。', 'warning');
                return $this->redirect(['/article/default/view', 'id' => $id]);
            }
            $model->user_id = Yii::$app->user->id;
            $model->post_id = $id;
            $model->ip = Yii::$app->getRequest()->getUserIP();
            if ($model->save()) {
                $this->flash("评论成功", 'success');
            } else {
                $this->flash(array_values($model->getFirstErrors())[0], 'warning');
            }
            return $this->redirect(['/article/default/view', 'id' => $id]);
        }
        return $model;
    }

    /**
     * 修改评论
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = PostComment::findComment($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/article/default/view', 'id' => $model->post_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 伪删除
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = PostComment::findComment($id);
        if (!$model->isCurrent()) {
            throw new NotFoundHttpException();
        }
        // 事物 暂时数据库类型不支持 无效
        $transaction = \Yii::$app->db->beginTransaction();
        $updateComment = $model->updateCounters(['status' => -1]);
        $updateNotify = Notification::updateAll(['status' => 0], ['comment_id' => $model->id]);
        $updateTopic = Article::updateAllCounters(['comment_count' => -1], ['id' => $model->post_id]);
        if ($updateNotify && $updateComment && $updateTopic) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }
        return $this->redirect(['/article/default/view', 'id' => $model->post_id]);
    }

}
