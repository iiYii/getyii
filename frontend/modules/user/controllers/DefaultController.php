<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;
use common\models\User;
use common\models\Post;
use common\models\UserInfo;
use common\models\PostComment;
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
        // 个人主页浏览次数
        UserInfo::updateAllCounters(['view_count' =>1], ['user_id' => $user->id]);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' =>$this->comment($user->id),
        ]);
    }

    protected function comment($userId)
    {
        return new ActiveDataProvider([
            'query' => PostComment::find()->where(['user_id' => $userId,'status' => 1])->orderBy(['created_at' => SORT_DESC]),
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

        $dataProvider = $this->getDataProvider($user->id);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' =>$dataProvider,
        ]);
    }


    protected function getDataProvider($userid)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['user_id' => $userid,'status' => 1])->orderBy(['created_at' => SORT_DESC]),
        ]);
        return $dataProvider;
    
    }
    /**
     * 最新收藏
     * @param  string $username [description]
     * @return [type]           [description]
     */
    public function actionFavorite($username='')
    {
        $user = $this->user($username);

        $dataProvider = $this->getDataProvider($user->id);

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
