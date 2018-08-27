<?php

use kartik\file\FileInput;
use backend\widgets\LanguageSelector;
use yii\helpers\Html;

/**
 * @var $this  yii\web\View
 */
?>

<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>


<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'single_line')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'multi_line')->widget(\common\widgets\CKEditor::class, [
    'preset' => 'full'
]) ?>

<?php
$pluginOptions = [
    'showUpload' => false
];
if($model->fileManagerImage && $model->fileManagerImage->name) {
    $pluginOptions['initialPreview'] = [Html::img($model->fileManagerImage->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->fileManagerImage->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->fileManagerImage ? $model->fileManagerImage->name : '',
            'size' => $model->fileManagerImage ? $model->fileManagerImage->size : '',
            'height' => "120px"
        ]
    ];
}
echo $form->field($model, 'image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false],
    'pluginOptions' => $pluginOptions,
]); ?>
