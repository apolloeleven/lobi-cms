<?php

/* @var $this \yii\web\View */
/* @var $content string */
/** @var \frontend\models\ContentTree $contentTreePage */

//$contentTreePage = \yii\helpers\ArrayHelper::getValue($this->params, 'contentTreePage');
//$pageModel = $contentTreePage->getModel();
$this->beginContent('@frontend/views/layouts/_clear.php')
?>
    <div class="main-wrapper">
        <?php echo $this->render('parts/header'); ?>
        <div class="global-wrapper-inner">
            <?php echo $content ?>
        </div>
        <?php echo $this->render('parts/footer'); ?>
    </div>
<?php $this->endContent() ?>
