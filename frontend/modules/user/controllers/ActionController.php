<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:11
 * description:
 */

namespace frontend\modules\user\controllers;

use common\services\TopicService;
use common\services\UserService;
use Yii;
use yii\filters\AccessControl;
use frontend\modules\user\models\Like;
use common\components\Controller;
use yii\web\NotFoundHttpException;

class ActionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    public function actionLike($type, $id)
    {
        switch ($type) {
            case 'topic':
                $topicService = new TopicService();
                $topic = $topicService->findTopic($id);
                $user = Yii::$app->user->getIdentity();
                list($result, $data) = UserService::TopicAction($user, $topic, 'like');
                break;

            case 'comment':
                # code...
                break;

            default:
                throw new NotFoundHttpException();
                break;
        }

        if ($result) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($data ? $data->getErrors() : '提交失败!');
        }
    }

    public function actionHate($type, $id)
    {
        if($type != 'topic'){
            throw new NotFoundHttpException();
        }
        $topicService = new TopicService();
        $topic = $topicService->findTopic($id);
        $user = Yii::$app->user->getIdentity();
        list($result, $data) = UserService::TopicAction($user, $topic, 'hate');

        if ($result) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($data ? $data->getErrors() : '提交失败!');
        }
    }

    public function actionFollow($type, $id)
    {
        if (true) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($like ? $like->getErrors() : '提交失败!');
        }
    }

    public function actionThanks($type, $id)
    {
        if (true) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($like ? $like->getErrors() : '提交失败!');
        }
    }

    public function actionFavorite($type, $id)
    {
        if (true) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($like ? $like->getErrors() : '提交失败!');
        }
    }

    public function actionTopic($id)
    {
        $topicService = new TopicService();
        $topic = $topicService->findTopic($id);
        $user = Yii::$app->user->getIdentity();

        list($result, $like) = Like::topic($user, $topic);

        if ($result) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($like ? $like->getErrors() : '提交失败!');
        }
    }

    public function actionComment($id)
    {
        $topicService = new TopicService();
        $comment = $topicService->findComment($id);
        $user = Yii::$app->user->getIdentity();

        list($result, $like) = Like::comment($user, $comment);

        if ($result) {
            return $this->message('提交成功!', 'success');
        } else {
            return $this->message($like ? $like->getErrors() : '提交失败!');
        }
    }
}