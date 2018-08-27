<?php

/**
 * @var $tableName
 * @var $breadCrumbs
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\BaseTranslateModel
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$title = Yii::t('backend', 'Update {modelClass}: ', [
        'modelClass' => $model->getModelClassName(),
    ]) . ' ' . $model->getTitle();

$BreadCrumb = [];

foreach ($breadCrumbs as $breadCrumb) {
    $BreadCrumb[] = ['label' => Yii::t('backend', $breadCrumb['name']), 'url' => $breadCrumb['url']];
}


$BreadCrumb[] = ['label' => Yii::t('backend', $model->getTitle()), 'url' => $url];
$BreadCrumb[] = Yii::t('backend', 'Update');
$this->params['breadcrumbs'] = $BreadCrumb;

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'options' => [
        'class' => 'lobi-form',
        'enctype' => 'multipart/form-data'
    ]
//    'enableAjaxValidation' => true,
]) ?>
<?php echo $this->render('/content-tree/buttons', ['model' => $model, 'url' => $url]); ?>
<h1><?php echo $title ?></h1>
<?php echo $this->render('@backend/views/_content/' . $tableName . '/_form', [
    'model' => $model,
    'form' => $form
]); ?>
<?php echo $this->render('/content-tree/buttons', ['model' => $model, 'url' => $url]); ?>
<?php echo Html::hiddenInput('go_to_parent','0',['id' => 'idGoToParent']); ?>
<?php ActiveForm::end() ?>