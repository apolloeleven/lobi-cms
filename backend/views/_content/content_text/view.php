<?php

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\ContentText
 */

use yii\helpers\Html;

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'activeTranslation.name',
        'activeTranslation.single_line',
        'activeTranslation.multi_line:html',
        [
            'label' => 'Image',
            'format' => 'html',
            'value' => function ($data) {
                if ($data->activeTranslation->fileManagerImage && substr($data->activeTranslation->fileManagerImage->type, 0, 6) === 'image/') {
                    return Html::img($data->activeTranslation->fileManagerImage->getUrl(), ['style' => 'width:120px']);
                }
                return '';
            }
        ],
        'created_at:datetime'
    ],
]);

?>
