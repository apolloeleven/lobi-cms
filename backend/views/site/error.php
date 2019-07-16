<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$buttons = \yii\helpers\ArrayHelper::getValue($this->params, 'errorPageButtons');

$code = property_exists($exception, 'statusCode') ? $exception->statusCode : 500;
?>
<div class="error">
    <div class="row">
        <div class="col-xs-12">
            <div class="error-page error-<?php echo $code ?>">
                <h1 class="error-page-code animated pulse"><i class="fa fa-warning"></i> Error <?php echo $code ?></h1>
                <h1 class="error-page-text"><?php echo nl2br(Html::encode($message)) ?></h1>

                <ul class="error-page-actions">
                    <?php if ($buttons): ?>
                        <?php foreach ($buttons as $button): ?>
                            <li>
                                <?php echo $button ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
</div><!-- /.error-page -->