<?php

namespace backend\controllers;

use intermundia\yiicms\models\SearchBackend;
use intermundia\yiicms\web\BackendController;
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
