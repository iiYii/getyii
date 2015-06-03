<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'member/<username:\w+>' => 'user/default/show',
                'member/<username:\w+>/post' => 'user/default/post',
                'member/<username:\w+>/favorite' => 'user/default/favorite',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                'member/<action>/<type:\w+>/<id:\d+>' => 'user/action/<action>',
                'tag/<tag:\w+>' => 'topic/default/index/',
                'node/<node:[0-9a-zA-Z\-]+>' => 'topic/default/index',
                '<module>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                // 'google' => [
                //     'class' => 'yii\authclient\clients\GoogleOpenId'
                // ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => 'github_client_id',
                    'clientSecret' => 'github_client_secret',
                ],
            ],
        ],
        'log' => [
            // 'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'exception*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        'topic' => [
            'class' => 'frontend\modules\topic\Module',
        ],
        'course' => [
            'class' => 'frontend\modules\course\Module',
        ],
    ],
    'params' => $params,
];
