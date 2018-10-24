<?php

use apollo11\lobicms\widgets\FileInput;
use backend\widgets\LanguageSelector;

/**
 * @var $this  yii\web\View
 * @var $model \apollo11\lobicms\models\CarouselItemTranslation
 */
?>


<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>

<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'caption')->widget(\common\widgets\CKEditor::class, [
    'preset' => 'full'
]) ?>

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

<?php echo $form->field($model, 'status')->checkbox() ?>
