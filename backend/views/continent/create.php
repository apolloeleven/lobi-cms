<?php

/* @var $this yii\web\View */
/* @var $model intermundia\yiicms\models\Continent */
/* @var $languages [] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Continent',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Continents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="continent-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>

</div>
