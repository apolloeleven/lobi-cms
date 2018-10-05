<?php
/**
 * User: zura
 * Date: 6/19/18
 * Time: 9:25 PM
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $contentTreeItem  \apollo11\lobicms\models\ContentTree */
/** @var $query  \apollo11\lobicms\models\query\ContentTreeQuery */
?>
    <br>
<?php
echo \yii\grid\GridView::widget([
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $query,
    ]),
    'tableOptions' => ['class' => 'table table-striped table-bordered', 'id' => 'content_tree_child'],
    'columns' => [
        [
            'label' => '',
            'content' => function () {
                return '<div style="cursor: pointer" class="pointer glyphicon glyphicon-align-justify"></div>';
            },
            'contentOptions' => ['class' => 'tree-children-draggable']
        ],
//            ['class' => SerialColumn::class, 'contentOptions' => ['class' => 'not-draggable']],
        [
            'attribute' => 'id',
            'contentOptions' => [
                'class' => 'priority'
            ],
            //'content' => function($model){
            //    /** @var $model \apollo11\lobicms\models\ContentTree */
            //    return \yii\bootstrap\Html::input('text','sequence',$model->id,['size'=>5]);
            //}
        ],
        [
            'label' => Yii::t('backend', 'Name'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return \yii\bootstrap\Html::a($model->getName(), $model->getFullUrl());
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'View'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                if ($model->hasCustomViews()) {
                    return Html::dropDownList('view', $model->view, $model->getViews(), ['class' => 'form-control view-dropdown']);
                } else {
                    return null;
                }
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'Show/Hide'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return Html::dropDownList('hide', $model->hide, ['Shown', 'Hidden'], ['class' => 'form-control hide-dropdown']);
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'Class'),
            'format' => 'html',
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return '<i class="fa ' .
                    Yii::$app->contentTree->getIcon($model->table_name, $model->link_id) . '"></i> '
                    . Yii::$app->contentTree->getDisplayName($model->table_name);
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'Alias'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return $model->getActualItemActiveTranslation()->alias;
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'Modifier'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return \common\models\User::findOne($model->updated_by)->username;
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'Modified at'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return Yii::$app->formatter->format($model->updated_at, 'datetime');
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ],
        [
            'label' => Yii::t('backend', 'Published at'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTree */
                return Yii::$app->formatter->format($model->created_at, 'datetime');
            },
            'contentOptions' => ['class' => 'not-draggable']
        ],
        ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {edit} {delete}',
            'contentOptions' => ['class' => 'not-draggable'],
            'buttons' => [
                'view' => function ($url, $model) {
                    /** @var \apollo11\lobicms\models\ContentTree $model */
                    $url = Url::to(['content-tree/index', 'nodes' => $model->getActualItemActiveTranslation()->alias_path]);
//                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                            'title' => Yii::t('backend', 'view'),
//                        ]);
                    return Html::a(Yii::t('backend', 'view'), $url, [
                        'title' => Yii::t('backend', 'view'),
                        [' class' => 'btn btn-warning btn-pretty btn-sm']
                    ]);
                },
                'edit' => function ($url, $model) {
                    /** @var \apollo11\lobicms\models\ContentTree $model */
                    $url = Url::to(['content-tree/update', 'id' => $model->id]);
                    return Html::a(Yii::t('backend', 'Edit'), $url, [
                        'title' => Yii::t('backend', 'Edit'),
                        [' class' => 'btn btn-default btn-pretty btn-sm']
                    ]);
                },
                'update' => function ($url, $contentTreeItem) {
                    /** @var \apollo11\lobicms\models\ContentTree $contentTreeItem */
                    /** @var \apollo11\lobicms\models\BaseModel $model */
                    $model = $contentTreeItem->getModel();
//                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $model->getUpdateUrl(), [
//                            'title' => Yii::t('backend', 'update'),
//                        ]);
                    return Html::a(Yii::t('backend', 'update'), $model->getUpdateUrl(), [
                        'title' => Yii::t('backend', 'update'),
                        [' class' => 'btn btn-primary btn-pretty btn-sm']
                    ]);
                },
                'delete' => function ($url, $contentTreeItem) {
                    /** @var \apollo11\lobicms\models\ContentTree $contentTreeItem */
                    /** @var \apollo11\lobicms\models\BaseModel $model */
                    $model = $contentTreeItem->getModel();
//                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $model->getDeleteUrl($contentTreeItem->id), [
//                            'title' => Yii::t('backend', 'delete'),
//                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//                            'data-method' => 'post',
//                        ]);
                    return Html::a(Yii::t('backend', 'delete'), $model->getDeleteUrl($contentTreeItem->id), [
                        'title' => Yii::t('backend', 'delete'),
                        [' class' => 'btn btn-danger btn-pretty btn-sm'],
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]);

                },
            ]
        ],
    ]
]);
