<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Shanghai', //time zone affect the formatter datetime format
    'components' => [
        'formatter' => [ //for the showing of date datetime
            'dateFormat' => 'yyyy-MM-dd',
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
            'useFileTransport' => true,
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => Yii::$app->setting->get('smtpHost'),
            //     'username' => Yii::$app->setting->get('smtpUser'),
            //     'password' => Yii::$app->setting->get('smtpPassword'),
            //     'port' => Yii::$app->setting->get('smtpPort'),
            //     'mail' => Yii::$app->setting->get('smtpMail'), // 显示地址
            //     // 'encryption' => 'tls',
            // ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
