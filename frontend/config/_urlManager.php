<?php

//use Sitemaped\Sitemap;

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
//        [
//            'pattern' => 'file/<action:[\w\-]+>',
//            'route' => 'file/<action>',
//        ],
        [
            'pattern' => 'sitemap.xml',
            'route' => 'site/sitemap-xml'
        ],
        [
            'pattern' => 'core/<controller>/<action>',
            'route' => 'core/<controller>/<action>'
        ],
        [
            'pattern' => '<action:(contact-submit|contact-success|search)>',
            'route' => 'site/<action>'
        ],
        [
            'pattern' => 'user/<controller:(sign-in)>/<action:[\w\-]+>',
            'route' => 'user/<controller>/<action>',
        ],
        [
            'pattern' => 'content-tree/edit-content',
            'route' => 'content-tree/edit-content',
        ],
        [
            'pattern' => 'content-tree/hide-section',
            'route' => 'content-tree/hide-section',
        ],
        [
            'pattern' => '<nodes:.*>',
            'route' => 'content-tree/index',
            'encodeParams' => false,
        ],
    ]
];
