<?php

namespace frontend\modules\topic\controllers;

use frontend\modules\topic\models\Topic;
use Yii;
use common\models\PostComment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for PostComment model.
 */
class CommentController extends Controller
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
        ];
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
            return $this->redirect(['/topic/default/view', 'id' => $model->post_id]);
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
        $model->updateCounters(['status' => -1]);
        Topic::updateAllCounters(['comment_count' => -1], ['id' => $model->post_id]);
        return $this->redirect(['/topic/default/view', 'id' => $model->post_id]);
    }

}
