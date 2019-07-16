<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception \Exception */

$this->title = $name;

$errorCode = 500;
if ($exception->statusCode == 404) {
    $errorCode = 404;
}
?>
<div class="site-error error<?php echo $errorCode ?>">
    <div class="container">
        <?php echo \intermundia\yiicms\widgets\DbText::widget([
            'key' => 'error' . $errorCode
        ]) ?>
    </div>
</div>
