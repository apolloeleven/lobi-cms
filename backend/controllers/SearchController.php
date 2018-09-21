<?php

namespace backend\controllers;

use apollo11\lobicms\models\Search;
use apollo11\lobicms\web\BackendController;
use Yii;

class SearchController extends BackendController
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
