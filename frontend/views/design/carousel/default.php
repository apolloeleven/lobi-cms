<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 7/25/18
 * Time: 6:12 PM
 * @author Saiat Kalbiev <kalbievich11@gmail.com>
 */
/** @var $this \yii\web\View */
/** @var $contentTreeItem \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \apollo11\lobicms\models\Carousel */

$itemsQuery = $contentTreeItem->getItemsQuery()->notDeleted();
(Yii::$app->user->canEditContent() && Yii::$app->request->get('hidden')) ?: $itemsQuery->notHidden();
$items = $itemsQuery->all();
?>

<div class="">
    <div class="xmlblock">
        <?php echo \common\widgets\Carousel::widget([
            'options' => [
                'class' => 'carousel slide'
            ],
            'items' => array_map(function ($item) {
                /** @var \frontend\models\ContentTree $item */
                /** @var \apollo11\lobicms\models\CarouselItem $model */
                $model = $item->getModel();
                return [
                    'content' => \yii\helpers\Html::img($model->activeTranslation->image->getUrl(), ['class' => 'img-responsive']),
                    'caption' => $model->activeTranslation->caption,
                    'showIndicators' => true,
                ];
            }, $items)
        ]) ?>
    </div>
</div>
