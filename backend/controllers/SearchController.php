<?php

namespace backend\controllers;

use apollo11\lobicms\models\Search;
use Yii;

class SearchController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
