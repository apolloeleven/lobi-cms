<?php

/* @var $this yii\web\View */
/* @var $model apollo11\lobicms\models\Menu */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Menu',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
