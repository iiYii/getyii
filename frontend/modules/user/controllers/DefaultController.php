<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;
use common\models\User;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->redirect(['show', 'id' => \Yii::$app->user->getId()]);
    }

    /**
     * Shows user's profile.
     * @param  integer $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($id)
    {
        $profile = User::findOne($id);

        if ($profile === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('show', [
            'profile' => $profile,
        ]);
    }
}
