<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model apollo11\lobicms\models\Continent */
/* @var $languages [] */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Continents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$attributes = [
    'code',
];

$tmp = [];
foreach ($model->translations as $translation) {
    $tmp[] = [
        'label' => "Title - " . $languages[$translation->language],
        'value' => $translation->name
    ];
}
$attributes = array_merge($attributes, $tmp);

$attributes[] = [
    'format' => 'html',
    'label' => 'Created Date',
    'value' => Yii::$app->formatter->asDatetime($model->created_at)
];

$attributes[] = [
    'format' => 'html',
    'label' => 'Updated Date',
    'value' => Yii::$app->formatter->asDatetime($model->updated_at)
];

?>

<div class="continent-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]) ?>

</div>
