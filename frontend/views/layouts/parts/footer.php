<?php

use intermundia\yiicms\widgets\DbText;

$items = \frontend\models\ContentTree::getFooterItems('footer');
$myItems = \intermundia\yiicms\widgets\NestedMenu::getItemsForFrontMenu();

/** @var  $logoImages intermundia\yiicms\models\FileManagerItem[] */
$logoImages = Yii::$app->websiteContentTree->getModel()->activeTranslation->logo_image;
?>
<footer>
    <div class="pre-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 pre-footer-logo">
                    <img
                            src="<?php echo $logoImages ? $logoImages[0]->getUrl() : "/img/logo.png" ?>"
                            alt="logo">
                </div>
                <div class="col-md-9 pre-footer-list">
                    <div>
                        <ul class="list-inline pre-footer-outer-list">
                            <?php foreach ($myItems as $footerItem): ?>
                                <li>
                                    <a href="<?php echo \yii\helpers\Url::to($footerItem['url']); ?>">
                                        <?php echo $footerItem['label']; ?>
                                    </a>
                                    <?php if (isset($footerItem['items'])): ?>
                                        <ul class="pre-footer-inner-list">
                                            <?php foreach ($footerItem['items'] as $page): ?>
                                                <li>
                                                    <a href="<?php echo \yii\helpers\Url::to($page['url']); ?>"><?php echo $page['label']; ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <?php $content = DbText::widget([
                        'key' => 'footer-callout-text'
                    ]) ?>
                    <?php if ($content): ?>
                        <div class="alert alert-info pre-footer-callout">
                            <?php echo $content ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="pre-footer-material-text">
                        <?php echo \intermundia\yiicms\widgets\DbText::widget([
                            'key' => 'pre-footer-material-text'
                        ]) ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="pre-footer-download-pdf">
                        <?php echo DbText::widget([
                            'key' => 'footer-download-pdf'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <p>
                        © <?php echo Yii::t('frontend', 'Lobi-cms'); ?> <?php echo date('Y'); ?>
                </div>
            </div>
        </div>
    </div>
</footer>
