<?php

use backend\widgets\LanguageSelector;
use common\widgets\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\WebsiteTranslation
 */

?>

<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>
<?php echo $form->field($model, 'short_description')->textarea() ?>
<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'og_site_name')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'address_of_company')->textInput(['maxlength' => true]) ?>

<?php
$pluginOptions = [
    'showUpload' => false
];
if ($model->fileManagerOgImage && $model->fileManagerOgImage->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
    $pluginOptions['initialPreview'] = [Html::img($model->fileManagerOgImage->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->fileManagerOgImage->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->fileManagerOgImage ? $model->fileManagerOgImage->name : '',
            'size' => $model->fileManagerOgImage ? $model->fileManagerOgImage->size : '',
            'height' => "120px",
            'key' => $model->fileManagerOgImage->id,
            'url' => Url::to(['base/delete-file-item'])
        ]
    ];
}
echo $form->field($model, 'og_image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false],
    'pluginOptions' => $pluginOptions,
]); ?>


<?php

$pluginOptions = [
    'showUpload' => false
];
if ($model->fileManagerLogoImage && $model->fileManagerLogoImage->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
    $pluginOptions['initialPreview'] = [Html::img($model->fileManagerLogoImage->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->fileManagerLogoImage->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->fileManagerLogoImage ? $model->fileManagerLogoImage->name : '',
            'size' => $model->fileManagerLogoImage ? $model->fileManagerLogoImage->size : '',
            'height' => "120px",
            'key' => $model->fileManagerLogoImage->id,
            'url' => Url::to(['base/delete-file-item'])
        ]
    ];
}

?>

<?php echo $form->field($model, 'logo_image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => $pluginOptions,
]); ?>

<?php
$pluginOptions = [
    'showUpload' => false
];
if ($model->fileManagerAdditionalLogoImage && $model->fileManagerAdditionalLogoImage->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
    $pluginOptions['initialPreview'] = [Html::img($model->fileManagerAdditionalLogoImage->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->fileManagerAdditionalLogoImage->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->fileManagerAdditionalLogoImage ? $model->fileManagerAdditionalLogoImage->name : '',
            'size' => $model->fileManagerAdditionalLogoImage ? $model->fileManagerAdditionalLogoImage->size : '',
            'height' => "120px",
            'key' => $model->fileManagerAdditionalLogoImage->id,
            'url' => Url::to(['base/delete-file-item'])
        ]
    ];
}

?>

<?php echo $form->field($model, 'additional_logo_image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => $pluginOptions,
]); ?>

<?php
$pluginOptions = [
    'showUpload' => false
];
if ($model->fileManagerClaimImage && $model->fileManagerClaimImage->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
    $pluginOptions['initialPreview'] = [Html::img($model->fileManagerClaimImage->getUrl(), ['style' => 'height:160px;'])];
    $pluginOptions['initialCaption'] = [$model->fileManagerClaimImage->name];
    $pluginOptions['initialPreviewConfig'] = [
        [
            'caption' => $model->fileManagerClaimImage ? $model->fileManagerClaimImage->name : '',
            'size' => $model->fileManagerClaimImage ? $model->fileManagerClaimImage->size : '',
            'height' => "120px",
            'key' => $model->fileManagerClaimImage->id,
            'url' => Url::to(['base/delete-file-item'])
        ]
    ];
}

?>

<?php echo $form->field($model, 'claim_image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => $pluginOptions,
]); ?>

<?php echo $form->field($model, 'copyright')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'google_tag_manager_code')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'html_code_before_close_body')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'footer_name')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'footer_headline')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'footer_plain_text')->widget(CKEditor::class, [
    'options' => ['rows' => 4],
    'preset' => 'full'
]) ?><?php echo $form->field($model, 'footer_copyright')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'footer_logo')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*'],
]); ?>
