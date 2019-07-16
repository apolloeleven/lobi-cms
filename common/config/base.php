<?php
$config = [
    'name' => 'lobi-cms.en',
    'vendorPath' => __DIR__ . '/../../vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en',
    'language' => env('DEFAULT_LANGUAGE', 'en'),
    'bootstrap' => ['log', 'contentTree'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],
        'ckEditorStyles' => [
            'class' => \intermundia\yiicms\components\CKEditorComponent::class,
            'customStyles' => [

            ]
        ],
        'contentTree' => [
            'class' => \intermundia\yiicms\components\ContentTree::class,
            'editableContent' => [
                \common\models\ContentTree::TABLE_NAME_PAGE => [
                    'class' => \common\models\Page::class,
                ],
                \common\models\ContentTree::TABLE_NAME_CONTENT_TEXT => [
                    'class' => \common\models\ContentText::class,
                ],
                \common\models\ContentTree::TABLE_NAME_VIDEO_SECTION => [
                    'class' => \common\models\VideoSection::class,
                ],
                \common\models\ContentTree::TABLE_NAME_WEBSITE => [
                    'class' => \common\models\Website::class,
                ],
            ],
            'customViews' => [
                \common\models\ContentTree::TABLE_NAME_PAGE => [
                    'home' => Yii::t('common', 'Home'),
                    'contact' => Yii::t('common', 'Contact'),
                    'sitemap' => Yii::t('common', 'Sitemap'),
                ],
                \common\models\ContentTree::TABLE_NAME_SECTION => [
                ],
                \common\models\ContentTree::TABLE_NAME_CONTENT_TEXT => [
                ]
            ]
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
            'cachePath' => '@common/runtime/cache'
        ],

        'commandBus' => [
            'class' => trntv\bus\CommandBus::class,
            'middlewares' => [
                [
                    'class' => trntv\bus\middlewares\BackgroundCommandMiddleware::class,
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],

        'formatter' => [
            'class' => \intermundia\yiicms\i18n\Formatter::class,
            'sizeFormatBase' => 1000
        ],

        'glide' => [
            'class' => trntv\glide\components\Glide::class,
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],

        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => env('ROBOT_EMAIL')
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('SMTP_HOST'),
                'username' => env('SMTP_USERNAME'),
                'password' => env('SMTP_PASSWORD'),
                'port' => env('SMTP_PORT'),
                'encryption' => env('SMTP_ENCRYPTION'),
            ],
        ],


        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 15 : 0,
            'targets' => [
                'db' => [
                    'class' => \yii\log\DbTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}'
                ]
            ],
        ],

        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
                'yii' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
//                '*' => [
//                    'class' => yii\i18n\PhpMessageSource::class,
//                    'basePath' => '@common/messages',
//                    'fileMap' => [
//                        'common' => 'common.php',
//                        'backend' => 'backend.php',
//                        'frontend' => 'frontend.php',
//                    ],
//                    'on missingTranslation' => [backend\modules\translation\Module::class, 'missingTranslation']
//                ],
                //Uncomment this code to use DbMessageSource
                '*' => [
                    'class' => 'intermundia\yiicms\i18n\DbMessageSource',
                    'sourceMessageTable' => '{{%i18n_source_message}}',
                    'messageTable' => '{{%i18n_message}}',
                    'enableCaching' => YII_ENV_DEV,
                    'cachingDuration' => 3600,
                    'on missingTranslation' => ['\backend\modules\translation\Module', 'missingTranslation']
                ],
            ],
        ],

        'fileStorage' => [
            'class' => trntv\filekit\Storage::class,
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => common\components\filesystem\LocalFlysystemBuilder::class,
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => common\behaviors\FileStorageLogBehavior::class,
                'component' => 'fileStorage'
            ]
        ],

        'keyStorage' => [
            'class' => common\components\keyStorage\KeyStorage::class
        ],

        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('BACKEND_HOST_INFO'),
                'baseUrl' => env('BACKEND_BASE_URL'),
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('FRONTEND_HOST_INFO'),
                'baseUrl' => env('FRONTEND_BASE_URL'),
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('STORAGE_HOST_INFO'),
                'baseUrl' => env('STORAGE_BASE_URL'),
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),

        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@common/runtime/queue',
        ],

        'view' => [
            'class' => \intermundia\yiicms\web\View::class,
        ],
        'multiSiteCore' => [
            'class' => \intermundia\yiicms\components\MultiSiteCore::class,
            'websites' => require(__DIR__ . '/multisite_websites.php')
        ],
    ],
    'params' => [
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'ccEmail' => env('CC_EMAIL'),
        'bccEmail' => env('BCC_EMAIL'),
        'availableLocales' => [
            'en' => 'English (US)',
            'de' => 'German',
        ],
    ],
    'on beforeRequest' => function () {
        Yii::$app->mailer->transport->setUsername(env('SMTP_USERNAME'));
        Yii::$app->mailer->transport->setPassword(env('SMTP_PASSWORD'));
    }
];

if (YII_ENV_PROD) {
    $config['components']['log']['targets']['slack'] = [
        'class' => \apollo11\logger\SlackTarget::class,
        'except' => ['yii\web\HttpException:*'],
        'webhookUrl' => env("SLACK_WEBHOOK_URL"),
        'levels' => ['error'],
        'title_link' => Yii::getAlias('@backendUrl'),
        'async' => false,
        'consoleAppPath' => Yii::getAlias('@console/yii'),
        'username' => 'Error Logs',
        'excludeKeys' => [
            '*DB*',
            '*PASSWORD*',
            'SMTP_*',
            '*KEY*',
            'SLACK_WEBHOOK_URL'
        ]
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class
    ];

    $config['components']['cache'] = [
        'class' => yii\caching\DummyCache::class
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
    ];
}

return $config;
