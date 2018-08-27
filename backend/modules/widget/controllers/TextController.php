<?php

namespace backend\modules\widget\controllers;

use backend\modules\widget\models\search\TextSearch;
use apollo11\lobicms\models\WidgetText;
use apollo11\lobicms\models\WidgetTextTranslation;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TextController extends Controller
{
    use FormAjaxValidationTrait;

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
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\base\ExitException
     */
    public function actionCreate($language)
    {
        $widgetText = new WidgetText();
        $widgetTextTranslation = new WidgetTextTranslation();
        $widgetTextTranslation->language = $language;

        $this->performAjaxValidation($widgetText);

        if ($widgetText->load(Yii::$app->request->post()) &&
            $widgetText->save() &&
            $widgetTextTranslation->setWidgetTextId($widgetText->id) &&
            $widgetTextTranslation->load(Yii::$app->request->post()) &&
            $widgetTextTranslation->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $widgetText,
                'modelTranslation' => $widgetTextTranslation
            ]);
        }
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\ExitException
     */
    public function actionUpdate($id, $language = null)
    {
        $language = $language ?: Yii::$app->language;
        $widgetText = $this->findWidget($id);
        $widgetTextTranslation = $widgetText->getTranslation()->andWhere(['language' => $language])->one() ?: new WidgetTextTranslation();
        $widgetTextTranslation->language = $language;

        $this->performAjaxValidation($widgetText);

        if ($widgetText->load(Yii::$app->request->post()) && $widgetText->save() &&
            $widgetTextTranslation->setWidgetTextId($widgetText->id) &&
            $widgetTextTranslation->load(Yii::$app->request->post()) &&
            $widgetTextTranslation->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $widgetText,
                'modelTranslation' => $widgetTextTranslation
            ]);
        }
    }

    /**
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findWidget($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @return WidgetText the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findWidget($id)
    {
        if (($model = WidgetText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
