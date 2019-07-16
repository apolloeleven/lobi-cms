<?php
/* @var $this yii\web\View */
/* @var $searchModel intermundia\yiicms\models\Search */

/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\widgets\SearchView;

$searchableWord = isset($_GET['Search']['content']) ? $_GET['Search']['content'] : '';

echo SearchView::widget([
    'dataProvider' => $dataProvider,
    'searchableWord' => $searchableWord
]);

?>
<?php //echo GridView::widget([
//    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
//    'options' => [
//        'class' => 'grid-view table-responsive',
//    ],
//    'columns' => [
//        [
//            'attribute' => 'table_name',
//            'value' => function($model){
//                return $model->contentTree->getTableName();
//            }
//        ],
//        [
//            'attribute' => 'attribute',
//            'value' => function($model){
//                return $model->attribute;
//            },
//        ],
//        [
//            'attribute' => 'content',
//            'value' => function($model){
//                return $model->content;
//            },
//        ],
//        [
//            'label' => 'Name',
//            'format' => 'raw',
//            'value' => function ($data) {
//                return Html::a($data->contentTree->activeTranslation->name, $data->contentTree->getFullUrl() , ['target' => '_blank']);
//            },
//        ],
//        ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}',
//            'contentOptions' => ['class' => 'not-draggable'],
//            'buttons' => [
//                'view' => function ($url, $searchModel) {
//                    /* @var $searchModel intermundia\yiicms\models\Search */
//                    $url =$searchModel->contentTree->getFullUrl();
//                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                        'title' => Yii::t('backend', 'view'),
//                    ]);
//                },
//                'update' => function ($url, $searchModel) {
//                    /* @var $baseModel intermundia\yiicms\models\BaseModel */
//                    $baseModel = $searchModel->contentTree->getModel();
//                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $baseModel->getUpdateUrl(), [
//                        'title' => Yii::t('backend', 'update'),
//                    ]);
//                },
//            ]
//        ],
//    ],
//]); ?>

