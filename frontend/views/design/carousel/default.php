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
/** @var $model \intermundia\yiicms\models\Carousel */

?>

<div class="carousel slide" data-ride="carousel">
    <?php echo $this->render('@frontend/views/content-tree/list', [
        'viewFile' => null,
        'contentTreeItem' => $contentTreeItem
    ]); ?>
</div>
