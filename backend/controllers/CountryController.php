<?php

namespace backend\controllers;

use apollo11\lobicms\models\Continent;
use apollo11\lobicms\models\Language;
use apollo11\lobicms\web\BackendController;
use Yii;
use apollo11\lobicms\models\Country;
use backend\models\search\CountrySearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends BackendController
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

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statuses' => Country::getStatuses(),
            'continents' => Continent::getContinentsMapped(),
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

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Country();
        $post = Yii::$app->request->post();
        $languages = Language::getAvailableLanguages();

        if ($model->load($post) && $model->saveWithTranslations($post,$languages)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'statuses' => Country::getStatuses(),
                'languages' => $languages,
                'continents' => Continent::getContinentsMapped(),
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
     * @throws \yii\db\Exception
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
                'statuses' => Country::getStatuses(),
                'languages' => $languages,
                'translations' => $translations,
                'continents' => Continent::getContinentsMapped(),
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
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->markDeleted();

        return $this->redirect(['index']);
    }

    /**
     * Find Country model. Trow NotFoundHttpException in case object was not found by ID
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $id
     * @return Country|array|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Country::find()->notDeleted()->byId($id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
