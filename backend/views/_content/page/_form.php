<?php

use backend\widgets\LanguageSelector;
use intermundia\yiicms\widgets\CKEditor;
use intermundia\yiicms\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this  yii\web\View
 * @var $model intermundia\yiicms\models\PageTranslation
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

<?php echo $form->field($model, 'meta_description')->textarea() ?>

<?php echo $form->field($model, 'meta_keywords')->textInput() ?>

<?php
echo $form->field($model, 'image[]')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => true],
]); ?>




