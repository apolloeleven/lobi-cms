<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 6/19/18
 * Time: 8:55 PM
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $tableName
 * @var $breadCrumbs
 * @var $this         yii\web\View
 * @var $searchModel  \backend\models\search\PageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        apollo11\lobicms\models\BaseTranslateModel
 */

$title = Yii::t('backend', 'Create {modelClass}', [
        'modelClass' => $model->getModelClassName(),
    ]) . ' ' . $model->getTitle();

$BreadCrumb = [];

foreach ($breadCrumbs as $breadCrumb) {
    $BreadCrumb[] = ['label' => Yii::t('backend', $breadCrumb['name']), 'url' => $breadCrumb['url']];
}

$BreadCrumb[] = ['label' => Yii::t('backend', $model->getModelClassName()), 'url' => ''];
$BreadCrumb[] = Yii::t('backend', 'Create');
$this->params['breadcrumbs'] = $BreadCrumb;
?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'options' => [
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