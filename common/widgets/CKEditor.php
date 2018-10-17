<?php
/**
 * User: zura
 * Date: 6/23/18
 * Time: 6:27 PM
 */

namespace common\widgets;

use dosamigos\ckeditor\CKEditorWidgetAsset;
use yii\helpers\Json;
use yii\web\View;


/**
 * Class CKEditor
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package common\widgets
 */
class CKEditor extends \dosamigos\ckeditor\CKEditor
{
    public $clientOptions = ['format_tags' => 'p;h1;h2;h3;h4;h5;h6;pre;address;div'];



    public function run()
    {
        parent::run();
        $csspath = getenv('FRONTEND_HOST_INFO') . '/bundle/style.css';

        // TODO: uncomment if necessary
        $configPath = getenv('BACKEND_HOST_INFO') . '/js/ck-config.js';

        $lobiUploaderPluginPath = getenv('BACKEND_HOST_INFO') . '/js/lobi-uploader.plugin.js';

        $this->getView()->registerJs("
        CKEDITOR.stylesSet.add( 'default', " . Json::encode(\Yii::$app->ckEditorStyles->customStyles) . " );
        CKEDITOR.config.contentsCss = '$csspath';
        CKEDITOR.config.bodyClass = 'xmlblock';
        CKEDITOR.config.removeButtons = 'Underline';
        
        // TODO: uncomment if necessary
        // CKEDITOR.config.customConfig = '$configPath';
        
        
        setTimeout(function(){
            $('.cke_contents').css('height','200px');
        },1000);
        ");

        $this->getView()->registerJsFile($lobiUploaderPluginPath,[
            'depends' => [
                CKEditorWidgetAsset::class
            ]
        ]);

    }
}
