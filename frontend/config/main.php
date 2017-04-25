<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'defaultRoute'=>'site/index',
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

                'node/<node:[0-9a-zA-Z\-]+>/topic' => 'topic/default/index',
                'node/<node:[0-9a-zA-Z\-]+>/article' => 'article/default/index',
                'node/<node:[0-9a-zA-Z\-]+>/question' => 'question/default/index',
                'node/<node:[0-9a-zA-Z\-]+>/video' => 'video/default/index',

                'topic/<id:[0-9a-zA-Z\-]+>' => 'topic/default/view',
                'article/<id:[0-9a-zA-Z\-]+>' => 'article/default/view',
                'question/<id:[0-9a-zA-Z\-]+>' => 'question/default/view',
                'video/<id:[0-9a-zA-Z\-]+>' => 'video/default/view',
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
        /*
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
        */
        'authClientCollection' => [
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
                    'clientId' => '111',
                    'clientSecret' => '111',
                ]

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
        'storage' => [
            'class' => 'weyii\filesystem\Manager',
            'default' => 'local',
            'disks' => [
                'local' => [
                    'class' => 'weyii\filesystem\adapters\Local',
                    'root' => '/wwwroot/dba-china.com/frontend/web/storage' // 本地存储路径
                ],
                'aliyun' => [
                    'class' => 'weyii\filesystem\adapters\AliYun',
                    'accessKeyId' => 'LTAIcGqyiKFzPARB',
                    'accessKeySecret' => 'I7qqfzNIojMn90qTC7GcAPB0DnFsLl',
                    'bucket' => 'dbachina',
                    // lanUrl和wanUrl样只需填写一个. 如果填写lanUrl 将优先使用lanUrl作为传输地址
                    // 外网和内网的使用参考: https://help.aliyun.com/document_detail/oss/user_guide/oss_concept/endpoint.html?spm=5176.2020520105.0.0.tpQOiL
                    'lanDomain' => 'oss-cn-shanghai.aliyuncs.com', // OSS内网地址, 如:oss-cn-hangzhou-internal.aliyuncs.com,默认不填. 在生产环境下保证OSS和服务器同属一个区域机房部署即可, 切记不能带上bucket前缀
                    'wanDomain' => 'oss-cn-shanghai.aliyuncs.com' // OSS外网地址, 如:oss-cn-hangzhou.aliyuncs.com 默认为杭州机房domain, 其他机房请自行替换, 切记不能带上bucket前缀
                ]

            ]
        ],
        'uuid' => [
            'class' => 'ollieday\uuid\Uuid',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        'topic' => [
            'class' => 'frontend\modules\topic\Module',
        ],
        'article' => [
            'class' => 'frontend\modules\article\Module',
        ],
        'question' => [
            'class' => 'frontend\modules\question\Module',
        ],
        'video' => [
            'class' => 'frontend\modules\video\Module',
        ],
        'nav' => [
            'class' => 'frontend\modules\nav\Module',
        ],
        'tweet' => [
            'class' => 'frontend\modules\tweet\Module',
        ],
        'manual' => [
            'class' => 'frontend\modules\manual\Module',
        ],
    ],
    'params' => $params,
];
