<?php
/**
 * Created by PhpStorm.
 * User: guga
 * Date: 6/26/18
 * Time: 12:08 PM
 */

use yii\helpers\Html;

?>


<div class="form-group" >
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create and go to parent') : Yii::t('backend', 'Update and go to parent'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'onclick' => 'document.getElementById("idGoToParent").value="1";'
        ]) ?>
    <?php echo Html::a(Yii::t('backend', 'Cancel'),[$url],['class' => 'btn btn-danger']) ?>
</div>