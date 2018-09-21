<?php
/* @var $this \yii\web\View */

use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

/* @var $content string */

$this->beginContent('@frontend/views/layouts/base.php')
?>

<?php echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
    <?php echo \yii\bootstrap\Alert::widget([
        'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ]) ?>
<?php endif; ?>

<?php echo $content ?>

<?php Modal::begin([
    'id' => 'feedbackModal',
    'closeButton' => [
            'label' => '<img src="/img/icons/close.svg" >'
    ],
    'header' => '<h3>Wie sehr hat Ihnen der Besuch dieser Website weitergeholfen?</h3>',
    'bodyOptions' => ['class' => 'modal-body'],
    'size' => 'modal-lg',
    'footer' => '',
]);

?>

<div id="rater" class="xmlblock">

</div>

<?php
Modal::end();
?>



<?php Modal::begin([
    'id' => 'cartModal',
    'options' => ['class' => 'container fade',],
    'closeButton' => [
        'label' => '<img src="/img/icons/close.svg" >'
    ],
    'header' => '<h4>' . Yii::t('frontend','Article was added in the cart') . '</h4>',
    'bodyOptions' => ['class' => 'modal-body'],
    'size' => 'modal-lg',
]);

?>

    <div class="xmlblock">
        <p><?php echo Yii::t('frontend','What should we do next?'); ?></p>
        <a href="<?php echo \yii\helpers\Url::to(['cart/index'])?>" class="complete-order">
            <span><?php echo Yii::t('frontend', 'Buy now'); ?></span>
        </a>
        <a href="/services" class="service-area">
            <span><?php echo Yii::t('frontend', 'Continue in services'); ?></span>
        </a>
    </div>


<?php
Modal::end();
?>

<?php Modal::begin([
    'id' => 'pdfCarouselModal',
    'closeButton' => [
        'label' => '<img src="/img/icons/close.svg" >'
    ],
    'header' => '<h4>' . Yii::t('frontend','PDF Images') . '</h4>',
    'bodyOptions' => ['class' => 'modal-body'],
    'size' => 'modal-lg',
]);

Modal::end()

?>


<?php $this->endContent() ?>