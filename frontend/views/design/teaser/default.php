<?php

/** @var \common\models\Teaser $model */

$content = $this->render('@frontend/views/content-tree/list', [
    'viewFile' => null,
    'contentTreeItem' => $contentTreeItem
]);
$root = \common\models\ContentTree::find()->roots()->one()->getModel();


?>

<?php

echo $model->activeTranslation->getTitle();

?>