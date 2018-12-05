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
            'pattern' => 'content-tree/get-alias-path',
            'route' => 'content-tree/get-alias-path',
        ],
        [
            'pattern' => '<nodes:.*>',
            'route' => 'content-tree/index',
            'encodeParams' => false,
        ],
        [
            'pattern' => 'content-tree/get-tree',
            'route' => 'content-tree/get-tree',
        ],
        [
            'pattern' => 'content-tree/link-tree',
            'route' => 'content-tree/link-tree',
        ],

//        // Pages
//        ['pattern' => 'page/<slug>', 'route' => 'page/view'],
//
//        // Articles
//        ['pattern' => 'article/index', 'route' => 'article/index'],
//        ['pattern' => 'article/attachment-download', 'route' => 'article/attachment-download'],
//        ['pattern' => 'article/<slug>', 'route' => 'article/view'],

        // Sitemap
//        ['pattern' => 'sitemap.xml', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML]],
//        ['pattern' => 'sitemap.txt', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_TXT]],
//        ['pattern' => 'sitemap.xml.gz', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML, 'gzip' => true]],
    ]
];
