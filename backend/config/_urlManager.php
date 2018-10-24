<?php
return [
    'class' => yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'pattern' => 'content/<nodes:.*>',
            'route' => 'content-tree/index',
            'encodeParams' => false,
        ],
        ['pattern' => 'content-tree/update/<id:\d+>', 'route' => 'content-tree/update'],
        ['pattern' => '<tableName:[\w\-\_]+>/<parentContentId:\d+>/create/<language:[\w+\-\w+]+>', 'route' => 'base/create'],
        ['pattern' => '<tableName:[\w\-\_]+>/<parentContentId:\d+>/update/<contentId:\d+>/<language:[\w\-]+>', 'route' => 'base/update'],
        ['pattern' => '<tableName:[\w\-\_]+>/<parentContentId:\d+>/view/<contentId:\d+>', 'route' => 'base/view'],
        ['pattern' => '<tableName:[\w\-\_]+>/<contentTreeId:\d+>/<id:\d+>', 'route' => 'base/delete'],
    ]
];
