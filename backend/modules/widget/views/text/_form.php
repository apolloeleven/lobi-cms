<?php

use apollo11\lobicms\widgets\CKEditor;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\WidgetText
 * @var $modelTranslation apollo11\lobicms\models\WidgetTextTranslation
 */

?>
<div class="widget-text-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]) ?>

    <?php echo $form->field($model, 'key')->textInput(['maxlength' => 1024]) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="well well-sm">

        <?php $languages = \apollo11\lobicms\models\Language::find()->all();
        echo $form->field($modelTranslation, 'language')
            ->dropDownList(\yii\helpers\ArrayHelper::map($languages, 'code', 'name'), [
                'options' => \yii\helpers\ArrayHelper::map($languages, 'code', function ($language) {
                    $params = array_merge([''], Yii::$app->request->get(), ['language' => $language->code]);
                    return [
                        'data-url' => \yii\helpers\Url::to($params)
                    ];
                })
            ]) ?>

        <?php echo $form->field($modelTranslation, 'title')->textInput(['maxlength' => 512]) ?>

        <?php echo $form->field($modelTranslation, 'body')->widget(CKEditor::class, [
            'options' => ['rows' => 10],
            'preset' => 'full'
        ]) ?>

        <?php echo $form->field($modelTranslation, 'short_description')->widget(CKEditor::class, [
            'options' => ['rows' => 10],
            'preset' => 'full'
        ]) ?>

    </div>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
