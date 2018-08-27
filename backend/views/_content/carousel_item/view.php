<?php

/**
 * @var $this  yii\web\View
 */

use yii\helpers\Html;

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'activeTranslation.name',
        'activeTranslation.caption:html',
//        'activeTranslation.status',
        [
            'label' => 'Image',
            'format' => 'html',
            'value' => Html::img($model->activeTranslation->image->getUrl(), ['style' => 'width: 120px;'])
        ],
        'created_at:datetime',
    ],
]);

?>
