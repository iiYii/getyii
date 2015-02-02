<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;
use common\models\User;
use common\models\UserInfo;

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
        $user = User::findOne($id);

        if ($user === null) {
            throw new NotFoundHttpException;
        }
        $profile = UserInfo::findOne($id);

        return $this->render('show', [
            'profile' => $profile,
            'user' => $user,
        ]);
    }
}
