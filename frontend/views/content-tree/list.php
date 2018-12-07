<?php
/**
 * User: zura
 * Date: 6/19/18
 * Time: 7:01 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $model  \common\models\BaseModel */
/** @var $viewFile string */
/** @var $withHidden string */
$itemsQuery = $contentTreeItem->getItemsQuery()->notDeleted();

(Yii::$app->user->canEditContent() && Yii::$app->request->get('hidden')) ?: $itemsQuery->notHidden();

$allItems = $itemsQuery->all();

echo \yii\widgets\ListView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $allItems
    ]),
    'options' => [
        'tag' => false
    ],
    'itemOptions' => [
        'tag' => false,
    ],
    'summary' => '',
    'itemView' => function ($item, $key, $index, $widget) use ($viewFile, $allItems) {
        /** @var \frontend\models\ContentTree $item */

        return $this->render('item_view',[
            'index' => $index,
            'item' => $item,
            'viewFile' => $viewFile,
            'allItems' => $allItems
        ]);
    }
]);
