<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/lobiadmin-with-plugins.css',
        'css/style.css',
        'css/bootstrap-tour.min.css',

    ];
    public $js = [
        'js/lobiplugins/lobibox.js',
        'js/highlight.pack.js',
        'js/ck-config.js',
        'js/config.js',
        'js/lobiadmin.js',
        'js/lobiadmin-app.js',
        'js/mark.js',
        'js/app.js',
        'js/bootstrap-tour.min.js',
        'js/jstree.min.js',
        'js/modal.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesome',
        'common\assets\Html5shiv',
        \dosamigos\ckeditor\CKEditorAsset::class
    ];
}
