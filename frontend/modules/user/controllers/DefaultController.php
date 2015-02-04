<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->redirect(['show', 'username' => \Yii::$app->user->identity->username]);
    }

    /**
     * Shows user's profile.
     * @param  integer $username
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($username='admin')
    {
        $user = User::findOne(['username' => $username]);

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('show', [
            'user' => $user,
        ]);
    }
}
