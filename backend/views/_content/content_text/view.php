<?php

/**
 * @var $this  yii\web\View
 * @var $model intermundia\yiicms\models\ContentText
 */

use yii\helpers\Html;

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'activeTranslation.name',
        'activeTranslation.single_line',
        'activeTranslation.multi_line:html',
        'activeTranslation.multi_line2:html',
        [
            'label' => 'Image',
            'format' => 'html',
            'value' => $model->activeTranslation->image ?
                Html::img($model->activeTranslation->image[0]->getUrl(), ['style' => 'width: 120px;']) : null
        ],
        'activeTranslation.alt_text',
        'created_at:datetime'
    ],
]);

?>
