<?php

use backend\widgets\LanguageSelector;
use common\widgets\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\PageTranslation
 */

?>

<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


<?php echo $form->field($model, 'short_description')->widget(CKEditor::class, [
    'options' => ['rows' => 4],
    'preset' => 'full'
]) ?>
<?php echo $form->field($model, 'body')->widget(CKEditor::class, [
    'options' => ['rows' => 10],
    'preset' => 'full'
]) ?>

<?php echo $form->field($model, 'meta_title')->textInput() ?>

<?php echo $form->field($model, 'meta_keywords')->textInput() ?>

<?php echo $form->field($model, 'meta_description')->textarea() ?>

<?php
$pluginOptions = [
    'showUpload' => false
];
if ($model->fileManagerImage && $model->fileManagerImage->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput()->label(false);
    $pluginOptions['initialPreview'] = [Html::img($model->fileManagerImage->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->fileManagerImage->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->fileManagerImage ? $model->fileManagerImage->name : '',
            'size' => $model->fileManagerImage ? $model->fileManagerImage->size : '',
            'height' => "120px",
            'key' => $model->fileManagerImage->id,
            'url' => Url::to(['base/delete-file-item'])
        ]
    ];
}

echo $form->field($model, 'image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false, 'id' => $model->id],
    'pluginOptions' => $pluginOptions,
]); ?>





