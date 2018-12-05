<?php
/**
 * User: zura
 * Date: 6/23/18
 * Time: 6:01 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \apollo11\lobicms\models\VideoSection */

?>
<div class="video-wrapper" <?php echo $contentTreeItem->getEditableAttributesForSection('section'); ?>>
    <video autoplay muted loop id="myVideo"
           main-src="<?php echo $model->activeTranslation->videoFile->getUrl() ?>"
           mobile-src="<?php echo $model->activeTranslation->mobileVideoFile->getUrl() ?>">

    </video>
    <div class="xmlblock-wrapper">
        <div class="xmlblock" <?php echo $contentTreeItem->getEditableAttributes('content_top', 'rich-text') ?>>
            <?php echo $model->activeTranslation->content_top ?>
        </div>
    </div>

</div>
