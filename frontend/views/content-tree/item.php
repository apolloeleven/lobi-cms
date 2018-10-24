<?php
/**
 * User: zura
 * Date: 6/24/18
 * Time: 2:52 PM
 */

/** @var $this \yii\web\View */
/** @var $index integer */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $model  \common\models\BaseModel */
?>

<section class="<?php echo $contentTreeItem->getCssClass() ?>" <?php echo $contentTreeItem->getEditableAttributesForSection('section'); ?>>
    <?php echo  $this->render( '@frontend/views/design/'.$contentTreeItem->table_name.'/'.($contentTreeItem->view ?: 'default'), [
        'index' => $index,
        'contentTreeItem' => $contentTreeItem,
        'model' => $contentTreeItem->getModel()
    ]); ?>
</section>