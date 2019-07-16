<?php

/* @var $this yii\web\View */
/* @var $searchModel intermundia\yiicms\models\Search */

/* @var $dataProvider yii\data\ArrayDataProvider */

use frontend\widgets\SearchView;

$searchableWord = $searchModel->content;

?>
<div id="page-search">
    <div class="container">
        <div class="page-content-wrapper">
            <?php echo SearchView::widget([
                'dataProvider' => $dataProvider,
                'searchableWord' => $searchableWord,
                'layout' => '{items}{pager}'
            ]);
            ?>
        </div>
    </div>
</div>

