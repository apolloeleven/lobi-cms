<?php

use intermundia\yiicms\models\Language;
use yii\helpers\Html;

echo \intermundia\yiicms\widgets\ContentEditingToolbar::widget();

$metaNavItems = \frontend\models\ContentTree::getItemsForMenu('header-meta-nav');
/** @var  $logoImages intermundia\yiicms\models\FileManagerItem[] */
$logoImages = Yii::$app->websiteContentTree->getModel()->activeTranslation->logo_image;

$languageDomains = array_unique(\Yii::$app->multiSiteCore->websites[Yii::$app->websiteContentTree->key]['domains']);
$activeLanguageIndex = 0;
$currentLanguage = null;
$protocol = Yii::$app->request->getIsSecureConnection() ? 'https' : 'http';
foreach ($languageDomains as $languageDomain => $langCode) {
    if (substr($langCode, 0, 2) == 'en') {
        unset($languageDomains[$languageDomain]);
    } else {

        $language = Language::find()->byCode($langCode)->one();
        $languageDomains[$languageDomain] = $language;
        if ($langCode == Yii::$app->language) {
            $currentLanguage = $language;
        }
    }
}
?>

<header>
    <nav id="headerTop" class="navbar navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand"
                   href="<?php echo \yii\helpers\Url::to(['content-tree/index', 'nodes' => '']) ?>">
                    <img class="img-logo"
                         src="<?php echo $logoImages ? $logoImages[0]->getUrl() : "/img/logo.png" ?>"
                         alt="<?php echo Yii::t('frontend', 'logo') ?>">
                </a>
            </div>


            <form class="navbar-form form-search navbar-right" method="get"
                  action="<?php echo \yii\helpers\Url::to(['/site/search']) ?>">
                <!--                    <div class="form-group">-->
                <!--                        <input type="text" class="form-control" placeholder="Search">-->
                <!--                    </div>-->

                <input class="form-control" name="content" value="<?php echo Yii::$app->request->get('content') ?>"
                       placeholder="<?php echo Yii::t('frontend', 'Type and search...') ?>">
                <button id="searchBtn" type="button" class="btn btn-default">
                    <i class="fa fa-search fa-rotate-90"></i>
                </button>
            </form>
            <?php echo \yii\bootstrap\Nav::widget([
                'options' => [
                    'class' => 'nav navbar-nav nav-meta navbar-right'
                ],
                'encodeLabels' => false,
                'items' => \intermundia\yiicms\helpers\Html::convertToNavData($metaNavItems)
            ]) ?>
            <?php if (count($languageDomains) > 1): ?>
                <ul class="nav navbar-nav nav-language navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" id="dropdownMenu"
                           data-toggle="dropdown">
                            <?php echo $currentLanguage->name ?>
                            <span class="dropdown-caret">
                            <img src="/icon/icon-nav-dropdown-primary.svg"/>
                        </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                            <?php foreach ($languageDomains as $url => $language) {
                                if ($language->code !== $currentLanguage->code) {
                                    echo Html::tag('li', Html::a($language->name, $protocol . '://' . $url));
                                }
                            } ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div><!-- /.container-fluid -->
    </nav>
    <nav id="headerBottom" class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button id="mobile-menu-toggle" type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span>
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </span>
                    <!--                    <img  src="/icon/icon-accordion-close.svg">-->
                </button>
                <a class="navbar-brand visible-sm visible-xs" href="/">
                    <img class="img-logo"
                         src="<?php echo $logoImages ? $logoImages[0]->getUrl() : "/img/logo.png" ?>"
                         alt="<?php echo Yii::t('frontend', 'logo') ?>">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php echo \intermundia\yiicms\widgets\NestedMenu::widget([
                    'dropDownCaret' => '<span class="dropdown-caret"><img src="/icon/icon-nav-dropdown-white.svg" /></span>',
                    'options' => [
                        'class' => 'nav navbar-nav navbar-menu'
                    ],
                ]) ?>
                <div class="visible-sm visible-xs">

                    <?php if (count($languageDomains) > 1): ?>
                        <ul class="nav navbar-nav nav-language">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" id="dropdownMenu"
                                   data-toggle="dropdown">
                                    <?php echo $currentLanguage->name ?>
                                    <span class="dropdown-caret">
                                    <img src="/icon/icon-nav-dropdown-white.svg"/>
                                </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                                    <?php foreach ($languageDomains as $url => $language) {
                                        if ($language->code !== $currentLanguage->code) {
                                            echo Html::tag('li', Html::a($language->name, $protocol . '://' . $url));
                                        }
                                    } ?>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>

                    <form class="navbar-form form-search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="content"
                                   value="<?php echo Yii::$app->request->get('content') ?>"
                                   placeholder="<?php echo Yii::t('frontend', 'Search') ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search fa-rotate-90 search-icon"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <?php echo \yii\bootstrap\Nav::widget([
                        'options' => [
                            'class' => 'nav navbar-nav nav-meta navbar-right'
                        ],
                        'items' => \intermundia\yiicms\helpers\Html::convertToNavData($metaNavItems)
                    ]) ?>
                </div>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
