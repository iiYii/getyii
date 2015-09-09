<?php

$MYSQL_PORT_3306_TCP_ADDR = env('MYSQL_PORT_3306_TCP_ADDR', 'localhost');
$MYSQL_TESTS_DB_NAME = env('MYSQL_INSTANCE_NAME', 'yii2advanced_tests');
$MYSQL_USERNAME = env('MYSQL_USERNAME', 'root');
$MYSQL_PASSWORD = env('MYSQL_PASSWORD', '');

/**
 * Application configuration shared by all applications and test types
 */
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.$MYSQL_PORT_3306_TCP_ADDR.';dbname='.$MYSQL_TESTS_DB_NAME,
            'username' => $MYSQL_USERNAME,
            'password' => $MYSQL_PASSWORD,
            'charset' => 'utf8mb4',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
