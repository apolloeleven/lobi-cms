<?php

namespace backend\controllers;

use apollo11\lobicms\models\ContentTreeMenu;
use apollo11\lobicms\web\BackendController;
use Yii;
use apollo11\lobicms\models\Menu;
use backend\models\MenuSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Response;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BackendController
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionChildren($id)
    {
        $model = $this->findModel($id);

        $contentTreeMenu = ContentTreeMenu::find()
            ->byMenuId($id)
            ->with(['contentTree', 'menu'])
            ->orderBy('position');

        return $this->render('sort', [
            'query' => $contentTreeMenu,
            'model' => $model,
        ]);
    }

    public function actionSort()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $prev = Yii::$app->request->post('prev');
        $next = Yii::$app->request->post('next');
        $element = Yii::$app->request->post('element');
        $transaction = Yii::$app->db->beginTransaction();
        $menuItems = ArrayHelper::index(ContentTreeMenu::find()->byId([$next, $prev, $element])->all(), 'id');

        if ($prev) {
            $prevItem = $menuItems[$prev];
            $newPos = $prevItem->position;
            Yii::$app->db->createCommand("UPDATE content_tree_menu SET position=position-1 WHERE position <= '$prevItem->position' ")->execute();
            ContentTreeMenu::updateAll(['position' => $newPos], ['id' => $element]);
            $transaction->commit();
            return ['success' => true];
        }

        if ($next) {
            $nextItem = $menuItems[$next];
            $newPos = $nextItem->position;
            Yii::$app->db->createCommand("UPDATE content_tree_menu SET position=position+1 WHERE position >= '$nextItem->position' ")->execute();
            ContentTreeMenu::updateAll(['position' => $newPos], ['id' => $element]);
            $transaction->commit();
            return ['success' => true];
        }

        return json_encode(Yii::$app->request->post());
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
