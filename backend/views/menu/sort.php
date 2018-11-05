<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 11/5/18
 * Time: 7:00 PM
 */

use yii\helpers\Html;

/** @var $query  \apollo11\lobicms\models\query\ContentTreeMenuQuery */

?>
<?php
echo \yii\grid\GridView::widget([
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 50
        ]
    ]),
    'tableOptions' => ['class' => 'table table-striped table-bordered', 'id' => 'menu_tree_item'],
    'columns' => [
        [
            'label' => '',
            'content' => function () {
                return '<div style="cursor: pointer" class="pointer glyphicon glyphicon-align-justify"></div>';
            },
            'contentOptions' => ['class' => 'tree-children-draggable']
        ],
        [
            'attribute' => 'position',
            'contentOptions' => [
                'class' => 'priority'
            ],
        ],
        [
            'label' => Yii::t('lobicmscore', 'Content Tree Item'),
            'content' => function ($model) {
                /** @var $model \apollo11\lobicms\models\ContentTreeMenu */
                return $model->contentTree->getName();
            },
            'contentOptions' => ['class' => 'not-draggable'],
        ]
    ]
]);
?>
