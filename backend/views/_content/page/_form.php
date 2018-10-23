<?php

use backend\widgets\LanguageSelector;
use common\widgets\CKEditor;
use apollo11\lobicms\widgets\FileInput;
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
if ($model->image && $model->image->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
    $pluginOptions['initialPreview'] = [Html::img($model->image->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->image->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->image ? $model->image->name : '',
            'size' => $model->image ? $model->image->size : '',
            'height' => "120px",
            'key' => $model->image->id,
            'url' => Url::to(['base/delete-file-item'])
        ]
    ];
}
echo $form->field($model, 'image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false],
    'pluginOptions' => $pluginOptions,
]); ?>




