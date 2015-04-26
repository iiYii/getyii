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

    /**
     * 过滤内容
     */
    public function filterSame($content)
    {
        $content = strtolower($content);
        $content = trim($content);
        $data = ['test', '测试'];
        if (in_array($content, $data)) {
            return false;
        }
        $action = ['+1', '赞', '很赞' , '喜欢', '收藏', 'mark', '写的不错', '不错', '给力', '顶', '沙发', '前排', '留名', '路过'];
        if (in_array($content, $action)) {
            return false;
        }
        return true;
    }

}