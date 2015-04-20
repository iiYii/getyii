<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use common\models\PostComment;

class CommentService
{

    public function userDoAction($id, $action)
    {
        $comment = PostComment::findComment($id);
        $user = \Yii::$app->user->getIdentity();
        if (in_array($action, ['like'])) {
            return UserService::CommentAction($user, $comment, $action);
        }
    }

}