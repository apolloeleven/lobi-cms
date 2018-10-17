<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => yii\web\AssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV
        ],
        'ckEditorStyles' => [
            'class' => \common\components\CKEditorComponent::class,
            'customStyles' => [
//                [
//                    "name" => 'My UL class',
//                    "element" => 'ul',
//                    "attributes" => ['class' => 'some-cool-class']
//                ],
//                [
//                    "name" => 'Another UL class',
//                    "element" => 'ul',
//                    "attributes" => ['class' => 'another-cool-class']
//                ],
                [
                    "name" => 'List icon hand',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-hand']
                ],
                [
                    "name" => 'List icon Magnifier',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-magnifier']
                ],
                [
                    "name" => 'List icon Thunderstorm',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-thunderstorm']
                ],
                [
                    "name" => 'List icon Three waves',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-three-waves']
                ],
                [
                    "name" => 'List icon Skull',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-skull']
                ],
                [
                    "name" => 'List icon Medicine',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-medicine']
                ],
                [
                    "name" => 'List icon Bullet',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-bullet']
                ],
                [
                    "name" => 'List icon Baby Crying',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-baby-crying']
                ],
                [
                    "name" => 'List icon Baby Smiles',
                    "element" => 'ul',
                    "attributes" => ['class' => 'list-icon-baby-smiles']
                ],
                [
                    "name" => 'Header video bubble',
                    "element" => 'p',
                    "attributes" => ['class' => 'bubble']
                ],
            ]
        ]
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
