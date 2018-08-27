<?php

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\Page
 */


use yii\helpers\Html;

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'activeTranslation.title',               // title attribute (in plain text)
        'activeTranslation.short_description:html',
        'activeTranslation.body:html',
        'activeTranslation.meta_title',
        'activeTranslation.meta_keywords',
        'activeTranslation.meta_description',
        [
            'label' => 'Image',
            'format' => 'html',
            'value' => function($data) {
                if($data->activeTranslation->fileManagerImage && substr($data->activeTranslation->fileManagerImage->type, 0,6) === 'image/') {
                    return Html::img($data->activeTranslation->fileManagerImage->getUrl(),['style' => 'width:120px']);
                }
                return '';
            }
        ],
        'created_at:datetime', // creation date formatted as datetime
        'updated_at:datetime',
    ],
]) ;

?>


