<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model intermundia\yiicms\models\Country */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $statuses [] */
/* @var $languages [] */
/* @var $continents [] */
/* @var $translations \intermundia\yiicms\models\CountryTranslation[] */

?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3">
            <?php echo $form->field($model, 'status')->dropDownList($statuses, []) ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->field($model, 'continent_id')->dropDownList($continents, [
                'prompt' => 'Choose Continent'
            ]) ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->field($model, 'iso_code_1')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->field($model, 'iso_code_2')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <?php
            $items = [];
            $ind = 0;

            foreach ($languages as $code => $name) {
                $className = \yii\helpers\StringHelper::basename(\intermundia\yiicms\models\CountryTranslation::className());

                if (isset($translations[$code])) {
                    $translationModel = $translations[$code];
                } else {
                    $translationModel = new \intermundia\yiicms\models\CountryTranslation();
                }


                $content = $form->field($translationModel, 'name', [
                    'inputOptions' => [
                        'name' => "{$className}[$code][name]",
                        'id' => "countrytranslation-name-{$code}"
                    ]
                ])->textInput(['maxlength' => 512]);

                $items[] = [
                    'label' => $name,
                    'content' => $content,
                    'headerOptions' => [
                        'title' => $translationModel->hasErrors() ? Yii::t('common', 'You have validation errors') : "",
                        'class' => $translationModel->hasErrors() ? 'has-error' : ''
                    ],
                    'options' => [
                        'class' => 'fade' . ($ind++ === 0 ? ' in' : ''),
                        'style' => 'padding:10px'
                    ]
                ];
            }


            echo '<div class="tab-wrapper">';

            echo Tabs::widget([
                'items' => $items
            ]);

            echo '</div>';
            ?>
        </div>
    </div>


    <br>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
