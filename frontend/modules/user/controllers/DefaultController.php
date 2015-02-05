<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;
use common\models\User;
use common\models\Post;
use yii\data\ActiveDataProvider;
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
    public function actionShow($username='')
    {
        $user = $this->user($username);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' =>$this->comment($username),
        ]);
    }

    protected function comment($username='')
    {
        return new ActiveDataProvider([
            'query' => Post::find(['username' => $username]),
        ]);
    }

    /**
     * 最近主题
     * @param  string $username [description]
     * @return [type]           [description]
     */
    public function actionPost($username='')
    {
        $user = $this->user($username);

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(['username' => $username]),
        ]);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' =>$dataProvider,
        ]);
    }

    /**
     * 最新收藏
     * @param  string $username [description]
     * @return [type]           [description]
     */
    public function actionFavorite($username='')
    {
        $user = $this->user($username);

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(['username' => $username]),
        ]);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' =>$dataProvider,
        ]);
    }

    protected function user($username='')
    {
        $user = User::findOne(['username' => $username]);

        if ($user === null) {
            throw new NotFoundHttpException;
        }
        return $user;
    }
}
