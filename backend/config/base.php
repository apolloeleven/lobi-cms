<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['ckEditorStyles'],
    'components' => [
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php'),
        'view' => [
            'class' => \intermundia\yiicms\web\BackendView::class,
        ],
    ],
];
