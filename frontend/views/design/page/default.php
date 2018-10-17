<?php
/**
 * User: zura
 * Date: 6/27/18
 * Time: 7:09 PM
 */

/** @var $this \yii\web\View */
/** @var $contentTreeItem  \frontend\models\ContentTree */
/** @var $index integer */
/** @var $model \apollo11\lobicms\models\Page */

$this->title = $model->activeTranslation->meta_title;
?>

{{content}}
