<?php

use common\grid\EnumColumn;
use intermundia\yiicms\models\WidgetText;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $this         yii\web\View
 * @var $searchModel  backend\modules\widget\models\search\TextSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('backend', 'Text Blocks');

$this->params['breadcrumbs'][] = $this->title;

?>
<p>
    <a href="<?php echo \yii\helpers\Url::to(['create', 'language' => Yii::$app->language])?>" class="btn btn-default">
        <i class="fa fa-plus"></i> <?php echo Yii::t('backend', 'Create Text Snippet') ?>
    </a>
</p>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'options' => ['style' => 'width: 5%'],
        ],
        [
            'attribute' => 'key',
            'options' => ['style' => 'width: 20%'],
        ],
        [
            'attribute' => 'title',
            'value' => function ($model) {
                return Html::a($model->getTitle(), ['update', 'id' => $model->id]);
            },
            'format' => 'raw',
        ],
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'options' => ['style' => 'width: 10%'],
            'enum' => WidgetText::statuses(),
            'filter' => WidgetText::statuses(),
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['style' => 'width: 5%'],
            'template' => '{update} {delete}',
        ],
    ],
]); ?>
