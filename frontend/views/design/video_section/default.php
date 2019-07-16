<?php
/**
 * User: zura
 * Date: 6/23/18
 * Time: 6:01 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \intermundia\yiicms\models\VideoSection */

?>
<div class="video-wrapper">
    <?php echo \intermundia\yiicms\helpers\Html::video($model, 'videoFile', [
        'autoplay' => true,
        'muted' => true,
        'loop' => true
    ]) ?>
</div>
