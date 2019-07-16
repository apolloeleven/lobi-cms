<?php
/**
 * User: zura
 * Date: 12/6/18
 * Time: 7:53 PM
 */

use intermundia\yiicms\components\NestedSetModel;
use frontend\models\ContentTree;

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \intermundia\yiicms\models\Page */

//$myItems = \intermundia\yiicms\widgets\NestedMenu::getItemsForFrontMenu();
$myItems = ContentTree::find()
    ->leftJoinOnTranslation()
    ->notHidden()
    ->notDeleted()
    ->with(['currentTranslation', 'defaultTranslation',])
    ->andWhere([
        ContentTree::tableName() . '.table_name' => [ContentTree::TABLE_NAME_PAGE, ContentTree::TABLE_NAME_WEBSITE]
    ])
    ->orderBy('lft')
    ->all();
$myItems = NestedSetModel::getMenuTree($myItems);

?>
<div id="sitemap">
    <div class="container">
        <ul class="sitemap-list">
            <?php foreach ($myItems as $footerItem): ?>
                <?php if (\yii\helpers\Url::to($footerItem['url']) !== "/" . Yii::$app->request->pathInfo): ?>
                    <li>
                        <a href="<?php echo \yii\helpers\Url::to($footerItem['url']); ?>">
                            <?php echo $footerItem['label']; ?>
                        </a>
                        <?php if (isset($footerItem['items'])): ?>
                            <ul class="pre-footer-inner-list">
                                <?php foreach ($footerItem['items'] as $page): ?>
                                    <li>
                                        <a href="<?php echo \yii\helpers\Url::to($page['url']); ?>"><?php echo $page['label']; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
