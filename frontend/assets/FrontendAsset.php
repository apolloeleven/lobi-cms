<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use common\assets\FontAwesome;
use common\assets\Html5shiv;
use dosamigos\ckeditor\CKEditorAsset;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@frontend/web';

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [
        'bundle/app.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
//        BootstrapAsset::class,
        Html5shiv::class,
        FontAwesome::class,
    ];

    public function init()
    {
        if (\Yii::$app->user->canEditContent()) {
            $this->depends[] = CKEditorAsset::class;
            $this->js[] = 'js/ck-config.js';
            $this->js[] = 'js/notify.min.js';
        }

        if (file_exists(\Yii::getAlias($this->basePath . '/bundle/style_' . \Yii::$app->language . '.css'))) {
            $this->css[] = 'bundle/style_' . \Yii::$app->language . '.css';
        } else {
            $this->css[] = 'bundle/style.css';
        }

        if (file_exists(\Yii::getAlias($this->basePath . '/bundle/style_' . \Yii::$app->language . '.js'))) {
            $this->js[] = 'bundle/style_' . \Yii::$app->language . '.js';
        }

        foreach ($this->css as &$css){
            $lastModifiedTime = filemtime($css);
            $css .= '?v=' . $lastModifiedTime;
        }

        foreach ($this->js as &$js){
            $lastModifiedTime = filemtime($js);
            $js .= '?v=' . $lastModifiedTime;
        }

        parent::init();
    }
}
