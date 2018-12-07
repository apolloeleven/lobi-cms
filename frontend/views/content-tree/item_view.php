<?php

/**
 * @var $this \apollo11\lobicms\web\View
 * @var $index integer
 * @var $globalViewPath string
 * @var $allItems \frontend\models\ContentTree[]
 * @var $item \frontend\models\ContentTree
 *
 */

$globalViewPath = Yii::$app->getViewPath();

if (file_exists($globalViewPath . '/content-tree/' . $item->table_name . '.php')) {
    $viewFile = $item->table_name;
}

$view = $viewFile ?: $item->view ?: 'default';
$content = '<!-- Start of ' . $item->table_name . ':' . ($item->view ?: 'default') . ':' . $item->id . '-->' . PHP_EOL;
$content .= $this->render($viewFile ?: '@frontend/views/design/' . $item->table_name . '/' . ($view),
    [
        'index' => $index,
        'contentTreeItem' => $item->getActualItem(),
        'originalItem' => $item,
        'allItems' => $allItems,
        'model' => $item->getModel(),
    ]);
$content .= PHP_EOL . '<!-- End of ' . $item->table_name . ':' . ($item->view ?: 'default') . ':' . $item->id . '-->';
echo $content;