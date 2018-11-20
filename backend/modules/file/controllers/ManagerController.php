<?php

namespace backend\modules\file\controllers;

use alexantr\elfinder\CKEditorAction;
use alexantr\elfinder\ConnectorAction;
use Yii;
use yii\web\Controller;

class ManagerController extends Controller
{
    /** @var string */
    public $layout = '//clear';

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'connector' => [
                'class' => ConnectorAction::class,
                'options' => [
                    'disabledCommands' => ['netmount'],
                    'connectOptions' => [
                        'filter'
                    ],
                    'roots' => [
                        [
                            'driver' => 'LocalFileSystem',
                            'path' => Yii::getAlias('@storage/web/source'),
                            'URL' => Yii::getAlias('@storageUrl/source'),
                            'uploadDeny' => [
                                'text/x-php', 'text/php', 'application/x-php', 'application/php'
                            ],
                        ],
                    ],
                ],
            ],
            'ckeditor' => [
                'class' => CKEditorAction::class,
                'connectorRoute' => 'connector',
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
