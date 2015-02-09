<?php
/**
 * @Author: forecho
 * @Date:   2015-01-24 22:21:45
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-24 22:35:02
 */

namespace frontend\modules\user\controllers;

use yii\base\Model;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\authclient\ClientInterface;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\UserAuth;

class SecurityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
        ];
    }

    public function init()
    {
        parent::init();
        \Yii::$app->set('authClientCollection', [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOpenId'
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => \Yii::$app->setting->get('githubClientId'),
                    'clientSecret' => \Yii::$app->setting->get('githubClientSecret'),
                ],
            ],
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
        $attributes = $client->getUserAttributes();
        $provider   = $client->getId();
        $clientId   = $attributes['id'];

        $account =  UserAuth::find()->where([
            'provider'  => $provider,
            'client_id' => $clientId
        ])->one();

        if ($account === null) {
            $account = \Yii::createObject([
                'class'      => UserAuth::className(),
                'type'       => $provider,
                'token'      => $clientId,
                'openid'     => json_encode($attributes),
                'created_at' => time()
            ]);
            $account->save(false);
        }

        if (null === ($user = $account->user)) {
            //$this->action->successUrl = Url::to(['/user/registration/connect', 'account_id' => $account->id]);
        } else {
            //\Yii::$app->user->login($user, $this->module->rememberFor);
        }
    }
}
