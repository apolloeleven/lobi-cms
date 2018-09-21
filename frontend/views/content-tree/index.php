<?php
/**
 * User: zura
 * Date: 6/19/18
 * Time: 7:01 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $model  \common\models\BaseModel */

$innerContent = $this->render('list', [
    'viewFile' => 'item',
    'contentTreeItem' => $contentTreeItem
]);


$content = $this->render('@frontend/views/design/' . $contentTreeItem->table_name . '/' . ($contentTreeItem->view ?: 'default'),
    [
        'contentTreeItem' => $contentTreeItem,
        'index' => 0,
        'model' => $contentTreeItem->getModel()
    ]);
echo str_replace('{{content}}', $innerContent, $content);
