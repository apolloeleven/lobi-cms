<?php

use backend\widgets\LanguageSelector;
use intermundia\yiicms\widgets\CKEditor;
use intermundia\yiicms\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this  yii\web\View
 * @var $model intermundia\yiicms\models\WebsiteTranslation
 */

?>

<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>
<?php echo $form->field($model, 'short_description')->textarea() ?>
<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'og_site_name')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'address_of_company')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'og_image[]')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => true],
]); ?>

<?php echo $form->field($model, 'logo_image[]')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => true],
]); ?>

<?php echo $form->field($model, 'additional_logo_image[]')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => true],
]); ?>

<?php echo $form->field($model, 'claim_image[]')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => true],
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
<?php
echo $form->field($model, 'image[]')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => true],
]); ?>


<?php echo $form->field($model, 'admin_email')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'cc_email')->textInput(['maxlength' => true]) ?>
<?php echo $form->field($model, 'bcc_email')->textInput(['maxlength' => true]) ?>
