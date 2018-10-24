<?php
/**
 * @var $this    yii\web\View
 * @var $content string
 */

use backend\assets\BackendAsset;
use backend\modules\system\models\SystemLog;
use backend\widgets\Menu;
use apollo11\lobicms\models\ContentTree;
use apollo11\lobicms\models\TimelineEvent;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);

?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>

<div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    <nav class="navbar navbar-default navbar-header header">
        <a class="navbar-brand" href="<?php echo Yii::getAlias('@frontendUrl') ?>">
            <div class="navbar-brand-img"></div>
            <!--<img src="img/logo/lobiadmin-logo-text-white-32.png" class="hidden-xs" alt="" />-->
        </a>
        <!--Menu show/hide toggle button-->
        <ul class="nav navbar-nav pull-left show-hide-menu">
            <li>
                <a href="#" class="border-radius-0 btn font-size-lg" data-action="show-hide-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>
        <form class="navbar-search pull-left" action="<?= Url::to(['/search']) ?>">
            <label for="search" class="sr-only">Search...</label>
            <input type="text" class="font-size-lg" name="Search[content]" id="content" placeholder="Search...">
            <a class="btn btn-search">
                <span class="glyphicon glyphicon-search"></span>
            </a>
            <a class="btn btn-remove">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </form>
        <div class="navbar-items">
            <!--User avatar dropdown-->
            <ul class="nav navbar-nav navbar-right user-actions">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle,
                            'img/anonymous.jpg')) ?>"
                             class="user-avatar">
                        <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Url::to(['/sign-in/profile']) ?>"><span
                                        class="glyphicon glyphicon-user"></span> &nbsp;&nbsp;Profile</a>
                        </li>
                        <li><a href="<?php echo Url::to(['/sign-in/account']) ?>"><span
                                        class="fa fa-key"></span> &nbsp;&nbsp;Account</a>
                        </li>
                        <li><a href="<?php echo Url::to(['/timeline-event/index']) ?>"><i class="fa fa-code-fork"></i>
                                &nbsp;&nbsp;Timeline</a></li>
                        <!--                        <li><a href="#lobimail"><span class="glyphicon glyphicon-envelope"></span> &nbsp;&nbsp;Messages</a></li>-->
                        <li class="divider"></li>
                        <li><a href="<?php echo Url::to(['/sign-in/lock']) ?>" data-method="post">
                                <span class="glyphicon glyphicon-lock"></span> &nbsp;&nbsp;Lock screen</a></li>
                        <li>
                            <a href="<?php echo Url::to(['/sign-in/logout']) ?>" data-method="post">
                                <span class="glyphicon glyphicon-off"></span>
                                &nbsp;&nbsp;<?php echo Yii::t('backend', 'Log out') ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix-xxs"></div>
        <div class="navbar-items-2">
            <!--Choose languages dropdown-->
            <ul class="nav navbar-nav navbar-actions">
                <li>
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-danger badge-xs">
                            <?php echo TimelineEvent::find()->today()->count() ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-notifications dropdown-timeline notification-news border-1 animated-fast flipInX">
                        <div class="notifications-heading border-bottom-1 bg-white">
                            <?php echo Yii::t('backend', 'Timeline') ?>
                        </div>
                        <ul class="notifications-body max-h-300">
                            <?php foreach (TimelineEvent::getLatestNItems() as $latestItem): ?>
                                <li>
                                    <div class="notification">
                                        <img class="notification-image"
                                             src="<?php echo $latestItem->getCreatorAvatar() ?>"
                                             alt="<?php echo $latestItem->getCreatorPublicIdentity() ?>">
                                        <div class="notification-msg">
                                            <h5 class="notification-sub-heading text-gray-darker">
                                                <?php echo $latestItem->getDisplayText() ?>
                                            </h5>
                                            <p class="body-text"><i
                                                        class="fa fa-clock-o"></i> <?php echo $latestItem->getDisplayDate() ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="notifications-footer border-top-1 bg-white text-center">
                            <?php echo Html::a(Yii::t('backend', 'View all'), ['/timeline-event/index']) ?>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-warning"></span>
                        <span class="badge badge-danger badge-xs"><?php $count = SystemLog::find()->count();
                            echo $count ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-notifications dropdown-system-logs notification-news border-1 animated-fast flipInX">
                        <div class="notifications-heading border-bottom-1 bg-white">
                            <?php echo Yii::t('backend', 'You have {num} log items',
                                ['num' => $count]) ?>
                        </div>
                        <ul class="notifications-body max-h-300">
                            <?php foreach (SystemLog::find()->orderBy(['log_time' => SORT_DESC])->limit(50)->all() as $logEntry): ?>
                                <li>
                                    <a href="<?php echo Yii::$app->urlManager->createUrl([
                                        '/system/log/view',
                                        'id' => $logEntry->id
                                    ]) ?>" class="notification">
                                        <i class="fa fa-warning <?php echo $logEntry->level === Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                        <?php echo $logEntry->category ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                        <div class="notifications-footer border-top-1 bg-white text-center">
                            <?php echo Html::a(Yii::t('backend', 'View all'), ['/system/log/index']) ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </nav>

    <div class="menu">
        <div class="menu-heading">
            <div class="menu-header-buttons-wrapper clearfix">
                <button type="button" class="btn btn-info btn-menu-header-collapse">
                    <i class="fa fa-cogs"></i>
                </button>
                <!--Put your favourite pages here-->
                <div class="menu-header-buttons">
                    <a href="<?php echo Url::to(['/sign-in/profile']) ?>" class="btn btn-info btn-outline"
                       data-title="Profile">
                        <i class="fa fa-user"></i>
                    </a>
                    <?php if (Yii::$app->user->can(\common\models\User::ROLE_MANAGER)): ?>
                        <a href="<?php echo Url::to(['/user/index']) ?>" class="btn btn-info btn-outline"
                           data-title="Users">
                            <i class="fa fa-users"></i>
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo Url::to(['/translation/default/index']) ?>" class="btn btn-info btn-outline"
                       data-title="Translations">
                        <i class="fa fa-language"></i>
                    </a>
                    <?php if (Yii::$app->user->can(\common\models\User::ROLE_MANAGER)): ?>
                        <a href="<?php echo Url::to(['/system/cache/index']) ?>" class="btn btn-info btn-outline"
                           data-title="Cache">
                            <i class="fa fa-refresh"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <nav>
            <?php

            echo Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'linkTemplate' => '<a href="{url}"><i class="{icon} menu-item-icon"></i><span class="inner-text">{label}</span>{badge}</a>',
                'activateParents' => true,
                'activeCssClass' => 'opened',
                'items' => [
                    [
                        'label' => Yii::t('backend', 'Timeline'),
                        'icon' => 'fa fa-bar-chart-o',
                        'url' => ['/timeline-event/index'],
                        'badge' => TimelineEvent::find()->today()->count(),
                        'badgeBgClass' => 'label-success',
                    ],
                    [
                        'label' => Yii::t('backend', 'Content'),
                        'options' => ['class' => 'menu-items-header'],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'Content Tree'),
                        'icon' => 'fa fa-bar-chart-o',
                        'url' => ['/content-tree/index'],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                        'items' => ContentTree::getItemsAsTree([
                            'name' => 'label',
                            'alias',
                            'url' => function ($item, $parentItem) {
                                $url = $item['alias'];
                                /** @var $parentItem \apollo11\lobicms\components\Node */
                                if ($parentItem) {
                                    $processedData = $parentItem->getProcessedData();
                                    $url = $processedData['url']['nodes'] . '/' . $url;
                                }
                                return ['/content-tree/index', 'nodes' => $url];
                            },
                            'icon' => function ($item) {
                                return 'fa ' . Yii::$app->contentTree->getIcon($item['table_name'],
                                        $item['link_id']);
                            }
                        ])
                    ],
                    [
                        'label' => Yii::t('backend', 'Widgets'),
                        'url' => '#',
                        'icon' => 'fa fa-code',
                        'options' => ['class' => 'treeview'],
                        'active' => (Yii::$app->controller->module->id == 'widget'),
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Text Blocks'),
                                'url' => ['/widget/text/index'],
                                'icon' => 'fa fa-circle-o',
                                'active' => (Yii::$app->controller->id == 'text'),
                            ],
//                                [
//                                    'label' => Yii::t('backend', 'Menu'),
//                                    'url' => ['/widget/menu/index'],
//                                    'icon' => 'fa fa-circle-o',
//                                    'active' => (Yii::$app->controller->id == 'menu'),
//                                ],
//                                [
//                                    'label' => Yii::t('backend', 'Carousel'),
//                                    'url' => ['/widget/carousel/index'],
//                                    'icon' => 'fa fa-circle-o',
//                                    'active' => in_array(Yii::$app->controller->id, ['carousel', 'carousel-item']),
//                                ],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Menu'),
                        'url' => ['/menu'],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                        'icon' => 'fa fa-bars'
                    ],
                    [
                        'label' => Yii::t('backend', 'Translation'),
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                        'options' => ['class' => 'menu-items-header'],
                    ],
                    [
                        'label' => Yii::t('backend', 'Translation'),
                        'url' => ['/translation/default/index'],
                        'icon' => 'fa fa-language',
                        'active' => (Yii::$app->controller->module->id == 'translation'),
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'Country'),
                        'url' => ['/country/index'],
                        'icon' => 'fa fa-map',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'Continent'),
                        'url' => ['/continent/index'],
                        'icon' => 'fa fa-map',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_EDITOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'System'),
                        'options' => ['class' => 'menu-items-header'],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'Users'),
                        'icon' => 'fa fa-users',
                        'url' => ['/user/index'],
                        'active' => (Yii::$app->controller->id == 'user'),
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'RBAC Rules'),
                        'url' => '#',
                        'icon' => 'fa fa-flag',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR),
                        'options' => ['class' => 'treeview'],
                        'active' => in_array(Yii::$app->controller->id,
                            ['rbac-auth-assignment', 'rbac-auth-item', 'rbac-auth-item-child', 'rbac-auth-rule']),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Auth Assignment'),
                                'url' => ['/rbac/rbac-auth-assignment/index'],
                                'icon' => 'fa fa-circle-o',
                            ],
                            [
                                'label' => Yii::t('backend', 'Auth Items'),
                                'url' => ['/rbac/rbac-auth-item/index'],
                                'icon' => 'fa fa-circle-o',
                            ],
                            [
                                'label' => Yii::t('backend', 'Auth Item Child'),
                                'url' => ['/rbac/rbac-auth-item-child/index'],
                                'icon' => 'fa fa-circle-o',
                            ],
                            [
                                'label' => Yii::t('backend', 'Auth Rules'),
                                'url' => ['/rbac/rbac-auth-rule/index'],
                                'icon' => 'fa fa-circle-o',
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Files'),
                        'url' => '#',
                        'icon' => 'fa fa-th-large',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_MANAGER),
                        'options' => ['class' => 'treeview'],
                        'active' => (Yii::$app->controller->module->id == 'file'),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Storage'),
                                'url' => ['/file/storage/index'],
                                'icon' => 'fa fa-database',
                                'active' => (Yii::$app->controller->id == 'storage'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Manager'),
                                'url' => ['/file/manager/index'],
                                'icon' => 'fa fa-television',
                                'active' => (Yii::$app->controller->id == 'manager'),
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Key-Value Storage'),
                        'url' => ['/system/key-storage/index'],
                        'icon' => 'fa fa-arrows-h',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_MANAGER),
                        'active' => (Yii::$app->controller->id == 'key-storage'),
                    ],
                    [
                        'label' => Yii::t('backend', 'Cache'),
                        'url' => ['/system/cache/index'],
                        'icon' => 'fa fa-refresh',

                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'System Information'),
                        'url' => ['/system/information/index'],
                        'icon' => 'fa fa-dashboard',

                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR),
                    ],
                    [
                        'label' => Yii::t('backend', 'Logs'),
                        'url' => ['/system/log/index'],
                        'icon' => 'fa fa-warning',
                        'badge' => $count,
                        'badgeBgClass' => 'label-danger',

                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_ADMINISTRATOR),
                    ],
                ],
            ]);
            ?>
        </nav>
        <div class="menu-collapse-line">
            <!--Menu collapse/expand icon is put and control from LobiAdmin.js file-->
            <div class="menu-toggle-btn" data-action="collapse-expand-sidebar"></div>
        </div>
    </div>

    <div id="main">
        <div id="ribbon" class="hidden-print">
            <a href="#dashboard" class="btn-ribbon" data-container="#main" data-toggle="tooltip"
               data-title="Show dashboard"><i class="fa fa-home"></i></a>
            <span class="vertical-devider">&nbsp;</span>
            <button class="btn-ribbon" data-container="#main" data-action="reload" data-toggle="tooltip"
                    data-title="Reload content by ajax"><i class="fa fa-refresh"></i></button>
            <?php echo Breadcrumbs::widget([
                'homeLink' => false,
                'tag' => 'ol',
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div id="content">
            <h1>
                <?php echo $this->title ?>
                <?php if (isset($this->params['subtitle'])): ?>
                    <small><?php echo $this->params['subtitle'] ?></small>
                <?php endif; ?>
            </h1>

            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php echo Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                ]) ?>
            <?php endif; ?>

            <?php echo $content ?>
        </div>
    </div>
</div><!-- ./wrapper -->

<?php $this->endContent(); ?>
