<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model apollo11\lobicms\models\Continent */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $translations \apollo11\lobicms\models\ContinentTranslation[] */
/* @var $languages [] */
?>

<div class="continent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3">
            <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php
            $items = [];
            $ind = 0;

            foreach($languages as $code => $name){
                $className = \yii\helpers\StringHelper::basename(\apollo11\lobicms\models\ContinentTranslation::className());

                if(isset($translations[$code])) {
                    $translationModel = $translations[$code];
                } else {
                    $translationModel = new \apollo11\lobicms\models\ContinentTranslation();
                }


                $content = $form->field($translationModel, 'name', [
                    'inputOptions' => [
                        'name' => "{$className}[$code][name]",
                        'id' => "continenttranslation-name-{$code}"
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
