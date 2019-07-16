<?php
/* @var $this \yii\web\View */

use intermundia\yiicms\web\View;
use yii\bootstrap\Modal;
use apollo11\yii2GaOptOut\GaOpOut;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

$this->registerJs(\intermundia\yiicms\widgets\DbText::widget([
    'key' => 'usersnap-code'
]), View::POS_END);

if (($gaCode = Yii::$app->websiteContentTree->model->activeTranslation->google_tag_manager_code)) {

    $this->registerJsFile("https://www.googletagmanager.com/gtag/js?id=$gaCode", [
        'async' => true
    ]);

    $this->registerJs("
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', '$gaCode');
      ");

    GaOpOut::widget([
        'gaAppId' => $gaCode,
        'debug' => env('YII_DEBUG')
    ]);
}


$this->registerJs(\intermundia\yiicms\widgets\DbText::widget([
    'key' => 'other-third-party-code'
]), View::POS_END);

$this->beginContent('@frontend/views/layouts/base.php')
?>

<div class="container">
    <?php echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?php if (Yii::$app->session->hasFlash('alert')): ?>
        <br>
        <?php echo \yii\bootstrap\Alert::widget([
            'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
            'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
        ]) ?>
    <?php endif; ?>
</div>

<?php echo $content ?>
<?php $this->endContent() ?>
