<?php

use backend\widgets\LanguageSelector;

/**
 * @var $this  yii\web\View
 * @var $model \apollo11\lobicms\models\CarouselTranslation
 */
?>


<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>


<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'status')->checkbox() ?>
