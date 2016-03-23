<?php

namespace frontend\modules\user\controllers;

use frontend\modules\topic\models\Topic;
use frontend\modules\user\models\UserMeta;
use common\components\Controller;
use common\models\User;
use common\models\UserInfo;
use common\models\PostComment;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yiier\merit\models\MeritLog;
use yiier\merit\models\MeritTemplate;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->redirect(['show', 'username' => \Yii::$app->user->identity->username]);
    }

    /**
     * Shows user's profile.
     * @param  string $username
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($username = '')
    {
        $user = $this->user($username);
        // 个人主页浏览次数
        $currentUserId = \Yii::$app->getUser()->getId();
        if (null != $currentUserId
            && $user->id != $currentUserId
        ) {
            UserInfo::updateAllCounters(['view_count' => 1], ['user_id' => $user->id]);
        }

        return $this->render('show', [
            'user' => $user,
            'dataProvider' => $this->comment($user->id),
        ]);
    }

    protected function comment($userId)
    {
        return new ActiveDataProvider([
            'query' => PostComment::find()->where(['user_id' => $userId, 'status' => 1])->orderBy(['created_at' => SORT_DESC]),
        ]);
    }

    /**
     * 最近主题
     * @param string $username
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPost($username = '')
    {
        $user = $this->user($username);

        $dataProvider = new ActiveDataProvider([
            'query' => Topic::find()
                ->where(['user_id' => $user->id, 'type' => Topic::TYPE])
                ->andWhere('status > :status ', [':status' => Topic::STATUS_DELETED])
                ->orderBy(['created_at' => SORT_DESC]),
        ]);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 最新收藏
     * @param string $username
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFavorite($username = '')
    {
        $user = $this->user($username);

        $dataProvider = new ActiveDataProvider([
            'query' => UserMeta::find()->where([
                'user_id' => $user->id,
                'type' => 'favorite',
                'target_type' => 'topic',
            ])->orderBy(['created_at' => SORT_DESC])
        ]);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPoint($username = '')
    {
        $user = $this->user($username);

        $dataProvider = new ActiveDataProvider([
            'query' => MeritLog::find()->where([
                'user_id' => $user->id,
                'type' => 1,
            ])->orderBy(['created_at' => SORT_DESC])
        ]);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function user($username = '')
    {
        $user = User::findOne(['username' => $username]);

        if ($user === null) {
            throw new NotFoundHttpException;
        }
        return $user;
    }
}
