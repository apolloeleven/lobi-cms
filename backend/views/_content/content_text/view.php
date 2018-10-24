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
        'activeTranslation.multi_line2:html',
        [
            'label' => 'Image',
            'format' => 'html',
            'value' => Html::img($model->activeTranslation->image->getUrl(), ['style' => 'width: 120px;'])
        ],
        'created_at:datetime'
    ],
]);

?>
