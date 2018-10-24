<?php

use apollo11\lobicms\widgets\FileInput;
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

<?php echo $form->field($model, 'multi_line2')->widget(\common\widgets\CKEditor::class, [
    'preset' => 'full'
]) ?>

<?php
if ($model->image && $model->image->name) {
    echo $form->field($model, 'deletedImages')->hiddenInput();
}
echo $form->field($model, 'image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false],
]); ?>