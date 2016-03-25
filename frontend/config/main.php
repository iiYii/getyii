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
                '<alias:login|logout|about|tags|getstart|signup|contact|users|markdown|at-users>' => 'site/<alias>',
                '<alias:search>' => 'topic/default/<alias>',
                'member/<username:\w+>' => 'user/default/show',
                'member/<username:\w+>/<alias:point|post|favorite>' => 'user/default/<alias>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                'member/<action>/<type:\w+>/<id:\d+>' => 'user/action/<action>',
                'tag/<tag:\w+>' => 'topic/default/index/',
                'node/<node:[0-9a-zA-Z\-]+>' => 'topic/default/index',
                'topic/<id:[0-9a-zA-Z\-]+>' => 'topic/default/view',
                '<module>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'as afterLogin' => 'frontend\behaviors\AfterLoginBehavior',
        ],
        'xunsearch' => [
            'class' => 'hightman\xunsearch\Connection', // 此行必须
            'iniDirectory' => '@frontend/config',    // 搜索 ini 文件目录，默认：@vendor/hightman/xunsearch/app
            'charset' => 'utf-8',   // 指定项目使用的默认编码，默认即时 utf-8，可不指定
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
                    'viewOptions' => [
                        'popupWidth' => 820,
                        'popupHeight' => 600,
                    ]
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
        'nav' => [
            'class' => 'frontend\modules\nav\Module',
        ],
        'tweet' => [
            'class' => 'frontend\modules\tweet\Module',
        ],
    ],
    'params' => $params,
];
