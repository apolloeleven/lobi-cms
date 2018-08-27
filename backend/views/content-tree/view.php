<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 7/27/18
 * Time: 10:48 AM
 */

/** @var $contentTreeItem  \apollo11\lobicms\models\ContentTree */
/** @var $model  \apollo11\lobicms\models\BaseModel */

$checked = $contentTreeItem->getMenuTreeModel();
$menus = \apollo11\lobicms\models\Menu::find()->all();
?>

<div class="content-view">
    <?php echo $this->render('@backend/views/_content/' . $contentTreeItem->table_name . '/view', [
        'model' => $model
    ]); ?>
</div>


