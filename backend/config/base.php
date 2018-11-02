<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php'),
        'view' => [
            'class' => \apollo11\lobicms\web\BackendView::class,
        ],
    ],
];
