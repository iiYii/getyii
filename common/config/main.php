<?php
	
$MYSQL_PORT_3306_TCP_ADDR = env('MYSQL_PORT_3306_TCP_ADDR', 'localhost');
$MYSQL_DB_NAME = env('MYSQL_INSTANCE_NAME', 'yii2advanced');
$MYSQL_USERNAME = env('MYSQL_USERNAME', 'root');
$MYSQL_PASSWORD = env('MYSQL_PASSWORD', '');

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Shanghai', //time zone affect the formatter datetime format
    'language' => 'zh-CN',
    'components' => [
        'formatter' => [ //for the showing of date datetime
            'dateFormat' => 'yyyy-MM-dd',
            'locale' => 'zh-CN',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'setting' => [
            'class' => 'funson86\setting\Setting',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            // 'db' => 'mydb',  // 数据库连接的应用组件ID，默认为'db'.
            'sessionTable' => 'session', // session 数据表名，默认为'session'.
        ],
	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.$MYSQL_PORT_3306_TCP_ADDR.';dbname='.$MYSQL_DB_NAME,
            'username' => $MYSQL_USERNAME,
            'password' => $MYSQL_PASSWORD,
            'charset' => 'utf8mb4',
	],
        'i18n' => [
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
];
