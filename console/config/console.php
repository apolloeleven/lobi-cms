<?php
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'command-bus' => [
            'class' => trntv\bus\console\BackgroundBusController::class,
        ],
        'message' => [
            'class' => console\controllers\ExtendedMessageController::class
        ],
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@common/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'rbac-migrate' => [
            'class' => console\controllers\RbacMigrateController::class,
            'migrationPath' => '@common/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile' => '@common/rbac/views/migration.php'
        ],
        'async' => [
            'class' => \apollo11\logger\AsyncController::class,
        ],
        'sync' => [
            'class' => \intermundia\yiicms\console\controllers\SyncController::class,
        ],
        'utils' => [
            'class' => \intermundia\yiicms\console\controllers\UtilsController::class,
        ],
    ],
    'components' => [
        'user' => [
            'class' => \yii\web\User::class,
            'enableSession' => false,
            'identityClass' => \common\models\User::class
        ]
    ]
];
