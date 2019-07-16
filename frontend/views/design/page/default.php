<?php
/**
 * User: zura
 * Date: 6/27/18
 * Time: 7:09 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \intermundia\yiicms\models\Page */

$itemsQuery = $contentTreeItem
    ->getItemsQuery([\common\models\ContentTree::TABLE_NAME_CONTENT_TEXT])
    ->andWhere("view IS NULL OR view = 'default' OR view = ''");
(Yii::$app->user->canEditContent() && Yii::$app->request->get('hidden')) ?: $itemsQuery->notHidden();
$children = $itemsQuery->all();


?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="xmlblock"><?php echo $model->activeTranslation->body ?></div>
        </div>
        <div class="col-lg-8 col-md-9">
            {{content}}
        </div>
        <div id="sidebar" class="col-md-3 col-lg-push-1">
            <div data-toggle="affix" data-spy="affix" data-offset-top="360" data-offset-bottom="">
                <ul class="nav">
                    <?php foreach ($children as $child): ?>
                        <li>
                            <a href="#id_<?php echo $child->id ?>"><?php echo $child->getModel()->activeTranslation->single_line ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


