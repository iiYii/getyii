<?php

$MYSQL_PORT_3306_TCP_ADDR = env('MYSQL_PORT_3306_TCP_ADDR', 'localhost');
$MYSQL_TESTS_DB_NAME = env('MYSQL_TESTS_DB_NAME', 'yii2advanced_tests');
$MYSQL_ROOT_PASSWORD = env('MYSQL_ROOT_PASSWORD', '');

/**
 * Application configuration shared by all applications and test types
 */
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.$MYSQL_PORT_3306_TCP_ADDR.';dbname='.$MYSQL_TESTS_DB_NAME,
            'username' => 'root',
            'password' => $MYSQL_ROOT_PASSWORD,
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
