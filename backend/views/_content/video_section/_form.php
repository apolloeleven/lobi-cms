<?php

use intermundia\yiicms\widgets\FileInput;
use intermundia\yiicms\widgets\CKEditor;
use backend\widgets\LanguageSelector;

/**
 * @var $this  yii\web\View
 * @var $model intermundia\yiicms\models\VideoSectionTranslation
 */
?>

<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>


<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'content_top')->widget(CKEditor::class,[
    'preset' => 'full'
]) ?>

<?php echo $form->field($model, 'videoFile[]')->widget(FileInput::class, [
    'options' => ['multiple' => true],
]); ?>

<?php echo $form->field($model, 'image[]')->widget(FileInput::class, [
    'options' => ['multiple' => true],
]); ?>
