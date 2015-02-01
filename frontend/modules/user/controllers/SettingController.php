<?php

namespace frontend\modules\user\controllers;

use Yii;
use common\models\User;
use frontend\modules\user\models\AccountForm;
use common\models\UserInfo;
use yii\data\ActiveDataProvider;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SettingController implements the CRUD actions for User model.
 */
class SettingController extends Controller
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
     * 修改个人资料
     * @return mixed
     */
    public function actionProfile()
    {
        $model = UserInfo::findOne(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->tagline = $model->tagline;
            $user->save();

            $this->flash('更新成功', 'success');
            return $this->refresh();
        }
        // echo array_values($model->getFirstErrors())[0];

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionAccount()
    {
        /** @var SettingsForm $model */
        $model = Yii::createObject(AccountForm::className());
        // var_dump($model);
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '您的用户信息修改成功');
            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }


    /**
     *  第三方账号绑定
     * @return mixed
     */
    public function actionNetworks()
    {
        return $this->render('networks', [
            'user' => Yii::$app->user->identity
        ]);
    }


    /**
     * Performs ajax validation.
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            Yii::$app->end();
        }
    }
}
