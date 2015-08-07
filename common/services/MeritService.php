<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/8/7 下午3:20
 * description:
 */

namespace common\services;

use common\models\Merit;
use common\models\MeritLog;
use common\models\MeritTemplate;
use yii\base\Exception;

class MeritService
{
    /**
     * 更新积分
     * @param $actionName
     * @throws \yii\db\Exception
     */
    public static function update($actionName)
    {
        $model = MeritTemplate::find()->where(['action' => $actionName])->all();
        if ($model && is_array($model)) {
            $meritLog = new MeritLog();
            $merit = new Merit();
            $userId = \Yii::$app->user->identity->getId();

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($model as $key => $value) {
                    $_meritLog = clone $meritLog;
                    $_merit = clone $merit;

                    $userMerit = $_merit->findOne([
                        'user_id' => $userId,
                        'type' => $value->type,
                    ]);
                    if ($userMerit) {
                        $userMerit->setAttributes([
                            'merit' => $userMerit->merit + $value->increment
                        ]);
                    } else {
                        $userMerit = clone $merit;
                        $userMerit->setAttributes([
                            'merit' => $value->increment,
                            'user_id' => $userId,
                            'type' => $value->type,
                        ]);
                    }
                    if (!$userMerit->save()) {
                        throw new Exception(array_values($userMerit->getFirstErrors())[0]);
                    }

                    $_meritLog->setAttributes([
                        'user_id' => $userId,
                        'merit_template_id' => $value->id,
                        'type' => $value->type,
                        'description' => $value->description,
                        'action_type' => $value->action_type,
                        'increment' => $value->increment,
                    ]);
                    if (!$_meritLog->save()) {
                        throw new Exception(array_values($_meritLog->getFirstErrors())[0]);
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }


}