<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\models\Notification;
use frontend\modules\question\models\Question;

class QuestionService extends PostService
{

    public function userDoAction($id, $action)
    {
        $question = Question::findQuestion($id);
        $user = \Yii::$app->user->getIdentity();
        if (in_array($action, ['like', 'hate'])) {
            return UserService::ActionA($user, $question, $action);
        } else {
            return UserService::ActionB($user, $question, $action);
        }
    }

    /**
     * 撤销问答
     * @param Question $question
     */
    public static function revoke(Question $question)
    {
        $question->setAttributes(['status' => Question::STATUS_ACTIVE]);
        $question->save();
    }


}