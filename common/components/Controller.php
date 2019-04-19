<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yiier\merit\MeritBehavior;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'returnUrl' => [
                'class' => 'yiier\returnUrl\ReturnUrl',
                'uniqueIds' => ['site/qr', 'site/login', 'user/security/auth', 'site/reset-password']
            ],
            MeritBehavior::className(),
        ]);
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        } else {
            return false;
        }
    }

    public function afterAction($action, $result)
    {
        if (!Yii::$app->user->isGuest) {
            $actionName = "frontend@{$this->module->id}_{$this->id}_{$action->id}";
        }
        return parent::afterAction($action, $result);
    }

    /**
     * 显示flash信息
     * @param $message string 信息显示内容
     * @param string $type 信息显示类型, ['info', 'success', 'error', 'warning']
     * @param null $url 跳转地址
     * @throws \yii\base\ExitException
     */
    public function flash($message, $type = 'info', $url = null)
    {
        Yii::$app->getSession()->setFlash($type, $message);
        if ($url !== null) {
            Yii::$app->end(0, $this->redirect($url));
        }
    }

    /**
     * @param $message string 信息显示内容
     * @param string $type 信息显示类型, ['info', 'success', 'error', 'warning']
     * @param null $redirect 跳转地址
     * @param null $resultType 信息显示格式
     * @return array|string
     */
    public function message($message, $type = 'info', $redirect = null, $resultType = null)
    {
        $resultType === null && $resultType = Yii::$app->getRequest()->getIsAjax() ? 'json' : 'html';
        is_array($redirect) && $redirect = Url::to($redirect);
        $data = [
            'type' => $type,
            'message' => $message,
            'redirect' => $redirect
        ];

        if ($resultType === 'json') {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $data;
        } elseif ($resultType === 'html') {
            return $this->render('/common/message', $data);
        }
    }

    // public $ajaxLayout = '/ajaxMain';
    // public function findLayoutFile($view)
    // {
    //     if (($this->layout === null) && ($this->ajaxLayout !== false) && Yii::$app->getRequest()->getIsAjax()) {
    //         $this->layout = $this->ajaxLayout;
    //     }
    //     return parent::findLayoutFile($view);
    // }
}