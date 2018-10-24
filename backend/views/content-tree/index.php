<?php

/**
 * User: zura
 * Date: 6/19/18
 * Time: 7:01 PM
 */

use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \apollo11\lobicms\models\ContentTree */
/** @var $model  \apollo11\lobicms\models\BaseModel */

$model = $contentTreeItem->getModel();
$checked = $contentTreeItem->getMenuTreeModel();
$menus = \apollo11\lobicms\models\Menu::find()->all();
$locationQuery = $contentTreeItem->getLocation();

$this->title = Yii::t('backend', 'View {modelClass}: ', [
        'modelClass' => $model->getTableNameUpperCase(),
    ]) . ' ' . $model->getTitle();

$BreadCrumb = [];

foreach ($contentTreeItem->getBreadCrumbs() as $breadCrumb) {
    $BreadCrumb[] = ['label' => Yii::t('backend', $breadCrumb['name']), 'url' => $breadCrumb['url']];
}

$BreadCrumb[] = Yii::t('backend', 'View');
$this->params['breadcrumbs'] = $BreadCrumb;
$tableNames = array_map(function ($tableName) {
    return $tableName['displayName'];
}, Yii::$app->contentTree->getEditableClassesKey());

unset($tableNames['website']);
$tableNames['all'] = 'All';
?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" type="text/css"
          rel="stylesheet"/>

    <div class="well well-sm">

        <form action="<?php echo Url::to(['/base/menu']) ?>" method="post" id="show_in_menu" class="form-inline"
              style="display: inline-block">
            <input type="hidden" name="id" value="<?= $contentTreeItem->getTreeId() ?>">

            <?php echo Html::checkboxList('menu_ids[]', array_keys($checked), \yii\helpers\ArrayHelper::map($menus, 'id', 'name')); ?>
        </form>
    </div>

<?php

$view = $this->render('view', [
    'model' => $model,
    'contentTreeItem' => $contentTreeItem
]);

$location = $this->render('location', [
    'query' => $locationQuery,
    'contentTreeItem' => $contentTreeItem
]);


$items = [
    [
        'label' => Yii::t('common', 'View'),
        'content' => $view,
    ],
    [
        'label' =>
            Yii::t('common', 'Location') .
            ' (' . $locationQuery->count() . ') ',
        'content' => $location,
    ]
];

echo '<div class="tab-wrapper">';

echo Tabs::widget([
    'items' => $items
]);


?>
<?php echo Html::a('View', $contentTreeItem->getFrontendUrl(), ['class' => 'btn btn-warning  margin-5', 'target' => '_blank']); ?>
<?php echo Html::a('Update', $model->getUpdateUrl(), ['class' => 'btn btn-primary margin-5']); ?>
<?php if ($contentTreeItem->table_name != 'website'): ?>
    <?php echo Html::a(Yii::t('backend', 'delete'), $model->getDeleteUrl($contentTreeItem->id), [
        'title' => Yii::t('backend', 'delete'),
        [' class' => 'btn btn-danger  margin-5'],
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        'data-method' => 'post',
    ]); ?>
<?php endif; ?>
<?php echo Html::a('Live Content Editing', Url::to(['/base/user-login', 'id' => Yii::$app->user->id, 'url' => $contentTreeItem->getFrontendEditingPath()]),
    ['class' => 'btn btn-info margin-5', 'target' => '_blank']); ?>
    <hr>

    <div class="well well-sm">
        <?php

        echo ButtonDropdown::widget([
            'encodeLabel' => false,
            'options' => ['class' => 'btn btn-default'],
            'label' => '<i class="fa fa-plus"></i> ' . Yii::t('backend', 'Create Content'),
            'dropdown' => [
                'items' => array_map(function ($item) use ($contentTreeItem) {
                    return [
                        'label' => $item['displayName'],
                        'url' => ['base/create', 'tableName' => $item['tableName'], 'parentContentId' => $contentTreeItem->id, 'language' => Yii::$app->language],
                    ];
                }, Yii::$app->contentTree->getEditableClasses())
            ],
        ]); ?>
        <?php if ($contentTreeItem->id != 1): ?>
            <?php
            echo Html::button('Choose From Existing', ['style' => 'margin-left:10px;margin-right:10px; ', 'class' => 'btn btn-default', 'data-toggle' => 'modal', 'data-target' => '#linked', 'data-key' => $contentTreeItem->getTreeId()]);
            Modal::begin([
                'id' => 'linked',
                'header' => '<h2 style="margin-left: 50px" >Choose From Existing Trees</h2>',
                'bodyOptions' => ['class' => 'modal-body', 'id' => 'tree-modal-body', 'data-key' => $contentTreeItem->getTreeId()],
                'size' => 'modal-lg',
                'footer' => Html::button('Link', ['class' => 'btn btn-primary', 'id' => 'linked-button']),
            ]);

            ?>

            <form id="table_names_tree" class="form-inline"
                  style="display: inline-block">
                <?php echo Html::checkboxList('table_names', [], $tableNames); ?>
            </form>

            <div id="jstree-choose"></div>


            <?php
            Modal::end();
            echo Html::button('Move To', ['style' => 'margin-left:10px;margin-right:10px; ', 'class' => 'btn btn-default', 'data-toggle' => 'modal', 'data-target' => '#move-modal', 'data-key' => $contentTreeItem->getTreeId()]); ?>
        <?php endif; ?>
        <?php
        Modal::begin([
            'id' => 'move-modal',
            'header' => '<h2 style="margin-left: 50px" >Move From Tree To Tree</h2>',
            'bodyOptions' => ['class' => 'modal-body', 'id' => 'move-modal-body', 'data-key' => $contentTreeItem->getTreeId()],
            'size' => 'modal-lg',
            'footer' => Html::button('Move', ['class' => 'btn btn-primary', 'id' => 'move-button']),
        ]);
        ?>
        <form id="table_names_for_move" class="form-inline"
              style="display: inline-block">
            <?php echo Html::checkboxList('table_names_move_id', [], $tableNames); ?>
        </form>

        <div id="jstree-move"></div>


        <?php
        Modal::end();

        ?>
    </div>
<?php

echo $this->render('children', [
    'query' => $contentTreeItem->getDirectChildren()->notDeleted(),
    'contentTreeItem' => $contentTreeItem
]);
