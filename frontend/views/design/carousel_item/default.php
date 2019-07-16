<?php
/**
 * User: zura
 * Date: 11/29/18
 * Time: 7:40 PM
 */
/** @var $this \yii\web\View */
/** @var $contentTreeItem \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \intermundia\yiicms\models\CarouselItem */

?>

<div id="content_<?php echo $contentTreeItem->id ?>" class="<?php echo $contentTreeItem->getCssClass() ?>item active">
    <?php echo \common\helpers\Html::backgroundImage($model, 'image') ?>
    <div class="carousel-caption">
        <div class="display-table">
            <div class="display-table-cell">
                <div class="xmlblock">
                    <?php echo $model->activeTranslation->caption ?>
                </div>
            </div>
        </div>
    </div>
</div>
