<?php

use common\grid\EnumColumn;
use apollo11\lobicms\models\Page;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $this         yii\web\View
 * @var $searchModel  \backend\models\search\PageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        apollo11\lobicms\models\Page
 */

$this->title = Yii::t('backend', 'Pages');

$this->params['breadcrumbs'][] = $this->title;

?>
<div id="accordion" class="panel-group" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h4 class="panel-title">
                <?php echo Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Page']) ?>
                <i class="fa fa-plus-square icon-collapsed pull-right"></i>
                <i class="fa fa-minus-square icon-expanded pull-right"></i>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?php echo $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'grid-view table-responsive',
    ],
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'slug',
        ],
        [
            'attribute' => 'title',
            'value' => function ($model) {
                return Html::a($model->title, ['update', 'id' => $model->id]);
            },
            'format' => 'raw',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]); ?>
