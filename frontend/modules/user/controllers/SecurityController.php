<?php
/**
 * @Author: forecho
 * @Date:   2015-01-24 22:21:45
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-04-12 12:24:48
 */

namespace frontend\modules\user\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\components\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\authclient\ClientInterface;
use frontend\modules\user\models\UserAccount;

class SecurityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['logout'], 'roles' => ['@']],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ]);
    }

    public function init()
    {
        parent::init();
        \Yii::$app->set('authClientCollection', [
            'class' => 'yii\authclient\Collection',
            'clients' => [

                'qq' => [
                    'class' => 'xj\oauth\QqAuth',
                    'clientId' => '111',
                    'clientSecret' => '111',

                ],
                'weixin' => [
                    'class' => 'xj\oauth\WeixinAuth',
                    'clientId' => '111',
                    'clientSecret' => '111',
                ],
                'weibo' => [
                    'class' => 'xj\oauth\WeiboAuth',
                    'clientId' => '1350319650',
                    'clientSecret' => '6bf6568705714d0dab0902ec50e2e75a',
                ],


            ]
        ]);
    }

    /** @inheritdoc */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'authenticate'],
            ]
        ];
    }

    /**
     * Logs the user in if this social account has been already used. Otherwise shows registration form.
     * @param  ClientInterface $client
     * @return \yii\web\Response
     */
    public function authenticate(ClientInterface $client)
    {
        $provider = $client->getId(); // qq | sina | weixin
        $attributes = $client->getUserAttributes(); // basic info
        $clientId = $client->getOpenid(); //user openid
        $userInfo = $client->getUserInfo(); // user extend info
        //var_dump($provider, $attributes, $openid, $userInfo);exit;


        $account = UserAccount::find()->where([
            'provider' => $provider,
            'client_id' => $clientId
        ])->one();

        if ($account === null) {
            $account = \Yii::createObject([
                'class' => UserAccount::className(),
                'provider' => $provider,
                'client_id' => $clientId,
                'data' => json_encode($attributes),
                'created_at' => time()
            ]);
            $account->save(false);
        }

        if (null === ($user = $account->user)) {
            $this->action->successUrl = Url::to(['/site/connect', 'account_id' => $account->id]);
        } else {
            \Yii::$app->user->login($user, 1209600); // two weeks
        }
    }
}
