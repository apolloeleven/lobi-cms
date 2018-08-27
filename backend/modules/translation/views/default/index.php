<?php

use backend\modules\translation\models\Source;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * @var $this               yii\web\View
 * @var $searchModel        backend\modules\translation\models\search\SourceSearch
 * @var $dataProvider       yii\data\ActiveDataProvider
 * @var $model              \common\base\MultiModel
 * @var $languages          array
 */

$this->title = Yii::t('backend', 'Translation');
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="accordion" class="panel-group" role="tablist">
    <div class="panel panel-success">
        <div class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h4 class="panel-title">
                <?php echo Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Source Message']) ?>
                <i class="fa fa-plus-square icon-collapsed pull-right"></i>
                <i class="fa fa-minus-square icon-expanded pull-right"></i>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <?php echo $this->render('_form', [
                    'model' => $model,
                    'languages' => $languages,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php

$translationColumns = [];
foreach ($languages as $language => $name) {
    $translationColumns[] = [
        'attribute' => $language,
        'header' => $name,
        'value' => $language . '.translation',
    ];
}


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'grid-view table-responsive',
    ],
    'columns' => ArrayHelper::merge([
        [
            'attribute' => 'id',
            'options' => ['style' => 'width: 5%'],
        ],
        [
            'attribute' => 'category',
            'options' => ['style' => 'width: 10%'],
            'filter' => ArrayHelper::map(Source::find()->select('category')->distinct()->all(), 'category', 'category'),
        ],
        'message:ntext',
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['style' => 'width: 5%'],
            'template' => '{update} {delete}',
        ],
    ], $translationColumns),
]); ?>