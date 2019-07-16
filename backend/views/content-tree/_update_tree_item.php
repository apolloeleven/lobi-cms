<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/5/18
 * Time: 11:17 AM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \intermundia\yiicms\models\ContentTreeTranslation $model */
?>
<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'short_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
