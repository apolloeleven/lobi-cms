<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\Pjax;

/** @var $this \yii\web\View */
/** @var $contactFormModel \frontend\models\ContactForm */
/** @var $model \intermundia\yiicms\models\Page */

$labelPrefix = "<div class='success-message'>
                    <img src='/icon/icon-check-green.svg' alt='success'>
                </div>
                <div class='error-message'>
                    <img src='/icon/icon-close-red.svg' alt='error'>
                </div> ";

?>

<?php Pjax::begin([
    'enablePushState' => false
]); ?>

<?php /*if ($model->activeTranslation->short_description): */?><!--
    <div class="contact-disclaimer xmlblock">
        <?php /*echo $model->activeTranslation->short_description */?>
    </div>
--><?php /*endif; */?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'action' => ['/site/contact-submit'],
    'options' => [
        'data-pjax' => ''
    ],
    'fieldConfig' => [
//        'template' => "
//                        <div class='control-label-wrapper'>
//
//                            {label}
//                        </div>
//                        {input}
//                        {error}",
        'template' => '{input}{label}<span class="bar"></span>{hint}{error}'
    ]
]); ?>
    <div class="row">
        <div class="col-sm-5 contact-info">
            <?php echo $form->field($contactFormModel, 'name', [
                'inputOptions' => [
                    'required' => true
                ]
            ])->label($labelPrefix . Yii::t('frontend',  'Name') . '*') ?>

            <?php echo $form->field($contactFormModel, 'email', [
                'inputOptions' => [
                    'required' => true
                ]
            ])->label($labelPrefix . Yii::t('frontend',  'Email') . '*') ?>

        </div>
        <div class="col-xs-12 contact-body">
            <?php echo $form->field($contactFormModel, 'body')->textarea([
                'rows' => 6,
                'required' => true
            ])->label($labelPrefix . Yii::t('frontend',  'Message') . '*') ?>

            <input type="hidden" name="page_id" value="<?php echo $model->id ?>">
            <?php echo $form->field($contactFormModel, 'verifyCheckbox', [
                'template' => '{input}'
            ])->checkbox([
                'checked' => false,
                'required' => true,
                'label' => '<label for="contactform-verifycheckbox"><span class="checkbox-message">' .
                    \intermundia\yiicms\widgets\DbText::widget([
                        'key' => 'contact-form-checkbox-text'
                    ]) . '</span></label>'
            ]); ?>

            <?php echo Html::submitButton(Yii::t('frontend', 'SEND E-MAIL'),
                ['class' => 'btn btn-primary btn-lg', 'name' => 'contact-button']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
