<?php

use backend\widgets\LanguageSelector;

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\CountryTranslation
 */
?>

<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>

<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'template')->widget(\common\widgets\CKEditor::class,[
    'preset' => 'full',
    'clientOptions' => [
        'startupMode' => 'source'
    ]
]) ?>

<?php echo $form->field($model, 'description')->widget(\common\widgets\CKEditor::class,[
    'preset' => 'full'
]) ?>
