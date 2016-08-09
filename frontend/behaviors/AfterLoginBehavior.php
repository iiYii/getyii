<?php

namespace frontend\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\User;

/**
 * after login behavior
 */
class AfterLoginBehavior extends Behavior
{
    /**
     * @var int
     */
    public $attribute = 'logged_at';
    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * @param \yii\web\UserEvent $event
     * @return bool
     */
    public function afterLogin($event)
    {
        $model = $event->identity->userInfo;

        $model->login_count += 1;
        $model->prev_login_time = $model->last_login_time;
        $model->prev_login_ip = $model->last_login_ip;
        $model->last_login_time = time();
        $model->last_login_ip = Yii::$app->getRequest()->getUserIP();

        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }
        $model->session_id = Yii::$app->session->id;
        Yii::$app->session->close();

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }
}
