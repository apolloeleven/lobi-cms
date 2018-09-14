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
echo $form->field($model, 'image')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*', 'multiple' => false],
]); ?>

<?php echo $form->field($model, 'status')->checkbox() ?>
