<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => yii\web\AssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV,
            'bundles' => [
                \dosamigos\ckeditor\CKEditorAsset::class => [
                    'sourcePath' => '@common/web/ckeditor/'
                ]
            ]
        ],
    ],
    'as locale' => [
        'class' => common\behaviors\LocaleBehavior::class,
        'enablePreferredLanguage' => false,
        'domainLanguageMapping' => [
            'lobicms.test' => 'en',
            'lobicms.local' => 'de'
        ]
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '10.142.168.*'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}


return $config;
