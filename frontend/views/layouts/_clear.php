<?php

use yii\helpers\Html;

/* @var $this \intermundia\yiicms\web\View */
/* @var $content string */

$bundle = \frontend\assets\FrontendAsset::register($this);

$contentTreePage = $this->contentTreeObject;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0'>

    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
    <meta name="title"
          content="<?php echo Html::encode($this->getMetaTag('meta_title')) ?>"/>
    <meta name="author" content=""/>
    <meta name="copyright" content=""/>
    <meta name="description" content="<?php echo $this->getMetaTag('meta_description') ?>"/>
    <meta name="keywords" content="<?php echo $this->getMetaTag('meta_keywords') ?>"/>
    <meta name="Content-language" content="<?php echo $this->getMetaTag('language') ?>"/>

    <meta property="og:url" content="<?php echo Yii::$app->request->getAbsoluteUrl() ?>"/>
    <meta property="og:title"
          content="<?php echo Html::encode($this->getMetaTag('meta_title')) ?>"/>
    <meta property="og:image" content="<?php echo $this->getOgImage(); ?>"/>
    <meta property="og:site_name" content="<?php echo $this->getOgSitename() ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description"
          content="<?php echo $this->getMetaTag('meta_description') ?>"/>
    <meta property="og:locale" content="<?php echo $this->getMetaTag('language') ?>"/>

</head>

<body class="<?php echo $contentTreePage ? $contentTreePage->getCssClass() . ' ' . $contentTreePage->getCustomCssClass() : '' ?> <?php echo Yii::$app->user->canEditContent() ? 'content-editable' : '' ?>">
<?php $this->beginBody() ?>
<?php echo $content ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
