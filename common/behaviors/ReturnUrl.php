<?php

/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/3/16 10:14
 * description:
 */
namespace common\behaviors;

use Yii;
use yii\base\ActionFilter;

class ReturnUrl extends ActionFilter
{
    public $uniqueIds = ['site/login'];

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            if (!(Yii::$app->request->getIsAjax() || $this->isValidate())) {
                Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
            }
        }
        return true;
    }


    private function isValidate()
    {
        if (in_array(Yii::$app->controller->action->uniqueId, $this->uniqueIds)) {
            return true;
        }
        return false;
    }
}