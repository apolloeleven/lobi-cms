<?php

/**
 * @var $this  yii\web\View
 */

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'activeTranslation.name',
//        'activeTranslation.status',
        'created_at:datetime',
    ],
]);

?>
