<?php
/**
 * author     : forecho <caizh@chexiu.cn>
 * createTime : 2016/3/10 14:39
 * description:
 */

namespace backend\controllers;

use yii\filters\AccessControl;
use common\models\User;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            // 后台必须登录才能使用
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $uniqueid = $action->controller->action->uniqueid;
            if (!in_array($uniqueid, ['site/login', 'site/logout', 'site/error']) && !User::currUserIsSuperAdmin()) {
                throw new ForbiddenHttpException;
            }
            return true;
        } else {
            return false;
        }
    }
}