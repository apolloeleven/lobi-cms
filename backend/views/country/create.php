<?php

/* @var $this yii\web\View */
/* @var $model intermundia\yiicms\models\Country */
/* @var $statuses [] */
/* @var $languages [] */
/* @var $continents [] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Country',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'statuses' => $statuses,
        'languages' => $languages,
        'continents' => $continents,
    ]) ?>

</div>
