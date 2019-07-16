<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statuses [] */
/* @var $continents [] */

$this->title = Yii::t('backend', 'Countries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => 'Country',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'format' => 'html',
                'attribute' => 'status',
                'filter' => $statuses,
                'value' => function ($model) {
                    return $model->status ? "<span class='label label-success'>ACTIVE</span>" : "<span class='label label-danger'>DISABLED</span>";
                }
            ],
            [
                'attribute' => 'continent_id',
                'filter' => $continents,
                'value' => function($model) {
                    return \yii\helpers\ArrayHelper::getValue($model, 'continent.activeTranslation.name');
                }
            ],
            [
                'attribute' => 'name',
                'value' =>
                    function ($model) {
                        /** @var $model \intermundia\yiicms\models\Country */
                        return $model->activeTranslation ? $model->activeTranslation->name : "";
                    }
            ],
            'iso_code_1',
            'iso_code_2',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
