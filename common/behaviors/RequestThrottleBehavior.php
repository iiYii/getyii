<?php

/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2015-9-7 10:00:22
 * description: 插入行为
 */

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use Yii;
use yii\web\Controller;

class RequestThrottleBehavior extends Behavior
{
    /**
     * @var string 错误提示
     */
    public $warning = '回复内容不能重复提交';
    /**
     * @var int 持续时间 单位秒
     */
    public $duration = 60;

    /**
     * 事件
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'checkRepeatSubmit',
        ];
    }

    public function checkRepeatSubmit($event)
    {
//        $post = \Yii::$app->request->bodyParams;
//        unset($post['_csrf']);
//        $key = md5(json_encode($post));
        $key = Yii::$app->controller->action->uniqueId;

        $cache = Yii::$app->cache;
        if ($cache->get($key) === false) {
            // 没有数据  证明是初次进入 或者缓存失效
        } else {
            // 缓存还没失效
            // 是重复提交
            // 此处如果抛异常是防止过快提交的
            Yii::$app->getSession()->setFlash('warning', $this->warning);
            Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);
            $event->isValid = false;
        }

        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function (Event $event) use ($key) {
            // 这里证明AR已经插入了
            // 此处可以写入缓存
            Yii::$app->cache->set($key, time(), $this->duration);
        });
    }

}