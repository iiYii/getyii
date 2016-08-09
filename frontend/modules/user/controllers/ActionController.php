<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:11
 * description:
 */

namespace frontend\modules\user\controllers;

use common\services\CommentService;
use common\services\TopicService;
use common\services\TweetService;
use Yii;
use common\components\Controller;
use yii\web\NotFoundHttpException;

class ActionController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl)->send();
        }
        return parent::beforeAction($action);
    }

    /**
     * 赞话题和评论
     * @param $type
     * @param $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionLike($type, $id)
    {
        switch ($type) {
            case 'topic':
                $topicService = new TopicService();
                list($result, $data) = $topicService->userDoAction($id, 'like');
                break;
            case 'tweet':
                $tweetService = new TweetService();
                list($result, $data) = $tweetService->userDoAction($id, 'like');
                break;

            case 'comment':
                $commentService = new CommentService();
                list($result, $data) = $commentService->userDoAction($id, 'like');
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

    /**
     * 喝倒彩话题
     * @param $type
     * @param $id
     * @return array|string
     */
    public function actionHate($type, $id)
    {
        if ($type == 'topic') {
            $topicService = new TopicService();
            list($result, $data) = $topicService->userDoAction($id, 'hate');

            if ($result) {
                return $this->message('提交成功!', 'success');
            } else {
                return $this->message($data ? $data->getErrors() : '提交失败!');
            }
        }
    }

    /**
     * 关注话题
     * @param $type
     * @param $id
     * @return array|string
     */
    public function actionFollow($type, $id)
    {
        if ($type == 'topic') {
            $topicService = new TopicService();
            list($result, $data) = $topicService->userDoAction($id, 'follow');

            if ($result) {
                return $this->message('提交成功!', 'success');
            } else {
                return $this->message($data ? $data->getErrors() : '提交失败!');
            }
        }
    }

    /**
     * 感谢话题
     * @param $type
     * @param $id
     * @return array|string
     */
    public function actionThanks($type, $id)
    {
        if ($type == 'topic') {
            $topicService = new TopicService();
            list($result, $data) = $topicService->userDoAction($id, 'thanks');

            if ($result) {
                return $this->message('提交成功!', 'success');
            } else {
                return $this->message($data ? $data->getErrors() : '提交失败!');
            }
        }
    }

    /**
     * 收藏话题
     * @param $type
     * @param $id
     * @return array|string
     */
    public function actionFavorite($type, $id)
    {
        if ($type == 'topic') {
            $topicService = new TopicService();
            list($result, $data) = $topicService->userDoAction($id, 'favorite');

            if ($result) {
                return $this->message('提交成功!', 'success');
            } else {
                return $this->message($data ? $data->getErrors() : '提交失败!');
            }
        }
    }
}