<?php
/**
 * User: zura
 * Date: 6/24/18
 * Time: 7:18 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \apollo11\lobicms\models\ContentText */


?>

<div class="container">
    <div class="xmlblock-wrapper">
        <div class="xmlblock" <?php echo $contentTreeItem->getEditableAttributes('multi_line','rich-text') ?>>
            <?php echo $model->activeTranslation->multi_line; ?>
        </div>
    </div>
</div>
