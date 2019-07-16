<?php

/* @var $this yii\web\View */
/* @var $model intermundia\yiicms\models\Country */
/* @var $statuses [] */
/* @var $continents [] */
/* @var $languages [] */
/* @var $translations \intermundia\yiicms\models\CountryTranslation[] */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Country',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="country-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'statuses' => $statuses,
        'languages' => $languages,
        'translations' => $translations,
        'continents' => $continents,
    ]) ?>

</div>
