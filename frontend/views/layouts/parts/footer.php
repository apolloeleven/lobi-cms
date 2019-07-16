<?php

use intermundia\yiicms\widgets\DbText;

$items = \frontend\models\ContentTree::getFooterItems('footer');
$myItems = \intermundia\yiicms\widgets\NestedMenu::getItemsForFrontMenu();

/** @var  $logoImages intermundia\yiicms\models\FileManagerItem[] */
$logoImages = Yii::$app->websiteContentTree->getModel()->activeTranslation->logo_image;
?>
<footer>
    <div class="footer-content color-white disclaimer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-md-push-3 footer-navigation">
                    <ul class="">
                        <?php foreach ($items as $item): ?>
                            <li>
                                <a href="<?php echo $item->getPageUrl(true); ?>"><?php echo $item->activeTranslation->name; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-3 col-md-pull-6 footer-copyright">
                    <img
                            src="<?php echo $logoImages ? $logoImages[0]->getUrl() : "/img/logo.png" ?>"
                            alt="logo">

                    <p>
                        © <?php echo Yii::t('frontend', 'Lobi-cms'); ?> <?php echo date('Y'); ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>
