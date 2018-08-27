<?php

/* @var $this yii\web\View */
/* @var $model apollo11\lobicms\models\Continent */
/* @var $languages [] */
/* @var $translations \apollo11\lobicms\models\ContinentTranslation[] */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Continent',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Continents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="continent-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'translations' => $translations,
    ]) ?>

</div>
