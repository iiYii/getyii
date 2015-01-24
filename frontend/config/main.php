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
                // '<controller:\w+>/<id:\d+>'=>'<controller>',
                '<controller:\w+>' => 'post/index/<PostSearch[tags=\w+>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
                // '<controller:\w+Search[\w+]>'=>'<controller>/<action>',
                // '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                // '<controller:\w+>/<action:\w+>/<PostSearch[tags]:\w+>'=>'<controller>/',
                // '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'User' => [
            'class' => 'frontend\modules\user\module',
        ],
    ],
    'params' => $params,
];
