<?php

namespace backend\controllers;

use apollo11\lobicms\models\SearchBackend;
use apollo11\lobicms\web\BackendController;
use Yii;
use yii\data\ActiveDataProvider;

class SearchController extends BackendController
{
    public function actionIndex()
    {
        $searchModel = new SearchBackend();
        $query = $searchModel->search(Yii::$app->request->queryParams, '');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => new ActiveDataProvider([
                'query' => $query
            ]),
        ]);
    }

}
