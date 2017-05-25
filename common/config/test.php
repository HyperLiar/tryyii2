<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
        'db'    => [
            'class' => 'yii\db\Connection',
            'dsn'   => 'mysql:host=localhost,dbname=journal',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8',
        ],
    ],
];
