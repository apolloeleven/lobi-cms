<?php

use common\widgets\CKEditor;
use backend\widgets\LanguageSelector;

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\VideoSectionTranslation
 */
?>

<?php echo $form->field($model, 'language')->widget(LanguageSelector::class, []) ?>


<?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?php echo $form->field($model, 'content_top')->widget(CKEditor::class,[
    'preset' => 'full'
]) ?>

<?php echo $form->field($model, 'content_bottom')->widget(CKEditor::class, [
    'preset' => 'full'
]) ?>


<?php echo $form->field($model, 'videoFile', [
    'template' => '{label}<label class="input input-file">
        <div class="input-button">
            {input}
            <i class="fa fa-upload"></i>
            ' . Yii::t('backend', 'Choose file') . '
        </div><input type="text" readonly="" placeholder="" id="idVideoFileInput" value="' . ($model->fileManagerVideoFile ? $model->fileManagerVideoFile->name : '') . '">
    </label>',
    'inputOptions' => [
        'onchange' => "this.parentNode.nextSibling.value = this.value"
    ]
])->fileInput(); ?>
<?php echo $form->field($model, 'removeVideo')->hiddenInput(['id' => 'idRemoveVideo', 'value' => '0'])->label(false); ?>
<div class="row">
    <div class="col-md-12">
        <button class="pull-right btn btn-danger" id="idRemoveVideoButton">Remove Video</button>
    </div>
</div>



<?php echo $form->field($model, 'mobileVideoFile', [
    'template' => '{label}<label class="input input-file">
        <div class="input-button">
            {input}
            <i class="fa fa-upload"></i>
            ' . Yii::t('backend', 'Choose file') . '
        </div><input type="text" readonly="" placeholder="" id="idMobileVideoFileInput" value="' . ($model->fileManagerMobileVideoFile ? $model->fileManagerMobileVideoFile->name : '') . '">
    </label>',
    'inputOptions' => [
        'onchange' => "this.parentNode.nextSibling.value = this.value"
    ]
])->fileInput(); ?>
<?php echo $form->field($model, 'removeMobileVideo')->hiddenInput(['id' => 'idRemoveMobileVideo', 'value' => '0'])->label(false); ?>
<div class="row">
    <div class="col-md-12">
        <button class="pull-right btn btn-danger" id="idRemoveMobileVideoButton">Remove Mobile Video</button>
    </div>
</div>
