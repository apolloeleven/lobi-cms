<?php

use frontend\models\ContactForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \intermundia\yiicms\models\Page */

$contactFormModel = new ContactForm();
?>
<div class="site-contact container">
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <div class="contact-heading"><?php echo $model->activeTranslation->short_description ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <!--            <p class="">If you have any questions or suggestions feel free to contact us by submitting-->
            <!--                the-->
            <!--                contact form below.</p>-->
            <!--            <p>* = Required input.</p>-->

            <?php echo $this->render('@frontend/views/site/contact', [
                'contactFormModel' => $contactFormModel,
                'model' => $model
            ]) ?>
        </div>
        <?php if ($model->activeTranslation->body): ?>
            <div class="col-xs-12 col-md-4">
                <?php echo $model->activeTranslation->body; ?>
            </div>
        <?php endif; ?>
    </div>

</div>


