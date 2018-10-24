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
if ($model->image && $model->image->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
}
echo $form->field($model, 'image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false],
]); ?>




