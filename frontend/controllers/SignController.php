<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 上午10:17
 */

namespace frontend\controllers;


use common\models\Sign;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\MethodNotAllowedHttpException;

class SignController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['post']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'verbs' => ['get']
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            if (!Yii::$app->request->isPost) {
                throw new MethodNotAllowedHttpException('post');
            }
            Yii::$app->response->format = 'json';
            $sign = Sign::find()->where(['user_id' => Yii::$app->user->id])->one();
            if (empty($sign)) {
                $sign = new Sign();
                $sign->last_sign_at = time();
                $sign->user_id = Yii::$app->user->id;
                $sign->times = 1;
                $sign->continue_times = 1;
                $sign->save();
            } else {
                if (date('Ymd', $sign->last_sign_at) != date('Ymd')) {
                    // 如果上次签到是昨天,连续签到
                    if (date('Ymd', $sign->last_sign_at) == date('Ymd', time() - 60 * 60 *24)) {
                        $sign->continue_times += 1;
                    } else {
                        $sign->continue_times = 1;
                    }
                    $sign->last_sign_at = time();
                    $sign->times += 1;
                    $sign->save();
                }
            }
            return [
                'days' => $sign->continue_times
            ];
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Sign::findBySql('SELECT * FROM {{%sign}} WHERE FROM_UNIXTIME(last_sign_at, "%Y%m%d")  = "'. date('Ymd') . '" ORDER BY last_sign_at ASC'),
                'pagination' => [
                    'defaultPageSize' => 100
                ]
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider
            ]);
        }
    }
}