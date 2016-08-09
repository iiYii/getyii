<?php

namespace frontend\controllers;

use common\models\User;
use common\services\UserService;
use Yii;
use frontend\models\Notification;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'clear' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index', 'count'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['delete', 'clear'], 'verbs' => ['POST'], 'roles' => ['@']],
                ]
            ]
        ]);
    }

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Notification::find()->where(['user_id' => Yii::$app->user->id]),
            'sort' => ['defaultOrder' => [
                'created_at' => SORT_DESC,
                'id' => SORT_ASC,
            ]]
        ]);
        $notifyCount = UserService::findNotifyCount();
        UserService::clearNotifyCount();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'notifyCount' => $notifyCount,
        ]);
    }

    /**
     * 返回通知条数
     * @return mixed
     */
    public function actionCount()
    {
        $model = User::findOne(Yii::$app->user->id);
        return $model->notification_count;
    }

    /**
     * Deletes an existing Notification model.
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
     * 清空通知
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionClear()
    {
        Notification::deleteAll(['user_id' => Yii::$app->user->id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
