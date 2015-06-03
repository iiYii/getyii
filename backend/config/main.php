<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'modules' => [
        'setting' => [
            'class' => 'funson86\setting\Module',
            'controllerNamespace' => 'funson86\setting\controllers',
        ],
    ],
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
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
