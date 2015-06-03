<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/4/23 下午4:13
 * description:
 */

namespace frontend\widgets;

use common\services\UserService;

class Nav extends \yii\bootstrap\Widget
{

    public function run()
    {
        $notifyCount = UserService::findNotifyCount();

        return $this->render('nav', [
            'notifyCount' => $notifyCount,
        ]);
    }
}