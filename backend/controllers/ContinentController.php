<?php

namespace backend\controllers;

use intermundia\yiicms\models\Language;
use intermundia\yiicms\web\BackendController;
use Yii;
use intermundia\yiicms\models\Continent;
use backend\models\search\ContinentSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContinentController implements the CRUD actions for Continent model.
 */
class ContinentController extends BackendController
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ContinentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'languages' => Language::getAvailableLanguages()
        ]);
    }

    public function actionCreate()
    {
        $model = new Continent();
        $post = Yii::$app->request->post();
        $languages = Language::getAvailableLanguages();

        if ($model->load($post) && $model->saveWithTranslations($post,$languages)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'languages' => $languages
            ]);
        }
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        $languages = Language::getAvailableLanguages();
        $translations = ArrayHelper::index($model->translations, 'language');

        if ($model->load($post) && $model->saveWithTranslations($post,$languages)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'languages' => $languages,
                'translations' => $translations,
            ]);
        }
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->markDeleted();

        return $this->redirect(['index']);
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $id
     * @return Continent|array|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Continent::find()->notDeleted()->byId($id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
