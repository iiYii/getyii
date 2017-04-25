<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/19 下午3:20
 * description:
 */

namespace common\services;

use frontend\models\Notification;
use frontend\modules\video\models\Video;

class VideoService extends PostService
{

    public function userDoAction($id, $action)
    {
        $article = Video::findVideo($id);
        $user = \Yii::$app->user->getIdentity();
        if (in_array($action, ['like', 'hate'])) {
            return UserService::ActionA($user, $article, $action);
        } else {
            return UserService::ActionB($user, $article, $action);
        }
    }

    /**
     * 撤销
     * @param Video $video
     */
    public static function revoke(Video $video)
    {
        $video->setAttributes(['status' => Video::STATUS_ACTIVE]);
        $video->save();
    }

}