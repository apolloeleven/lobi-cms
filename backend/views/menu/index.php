<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'Menu',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'key',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update}{delete}{sort}',
                'buttons' => [
                    'sort' => function ($url, $model) {
                        /** @var \apollo11\lobicms\models\ContentTree $model */
                        $url = Url::to(['/menu/children', 'id' => $model->id]);
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-sort']), $url, [
                            'title' => Yii::t('lobicmscore', 'sort'),
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
