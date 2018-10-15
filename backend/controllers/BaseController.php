<?php

namespace backend\controllers;

use apollo11\lobicms\commands\AddToTimelineCommand;
use apollo11\lobicms\models\BaseModel;
use apollo11\lobicms\models\BaseTranslateModel;
use apollo11\lobicms\models\ContentTreeMenu;
use apollo11\lobicms\models\TimelineEvent;
use apollo11\lobicms\web\BackendController;
use common\models\User;
use apollo11\lobicms\models\UserToken;
use common\traits\FormAjaxValidationTrait;
use backend\models\ContentTree;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BaseController extends BackendController
{
    use FormAjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                ],
            ],
        ];
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'menu') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/content-tree/index']);
    }

    /**
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionCreate($tableName, $parentContentId, $language)
    {
        $ClassName = Yii::$app->contentTree->getClassName($tableName);
        $translateClass = $ClassName::getTranslateModelClass();
        /** @var BaseTranslateModel $translateModel */
        $translateModel = new $translateClass();
        $translateModel->parentContentId = $parentContentId;
        $translateModel->language = $language;

        $transaction = Yii::$app->db->beginTransaction();
        if ($translateModel->load(Yii::$app->request->post()) && $translateModel->save()) {
            if (intval(Yii::$app->request->post('go_to_parent'))) {
                $tree = ContentTree::find()->byId($parentContentId)->one();
            } else {
                $foreignKey = $translateModel->getForeignKeyNameOnModel();
                $tree = ContentTree::find()->byRecordIdTableName($translateModel->$foreignKey, $tableName)->one();
            }
            $transaction->commit();
            return $this->redirect($tree->getFullUrl());
        }
        $transaction->rollBack();
        $tree = ContentTree::find()->byId($parentContentId)->one();

        $breadCrumbs = $tree->getBreadCrumbs();
        return $this->render(
            '@backend/views/content-tree/create', [
            'model' => $translateModel,
            'tableName' => $tableName,
            'breadCrumbs' => $breadCrumbs,
            'url' => $tree->getFullUrl()
        ]);
    }

    /**
     * @param $tableName
     * @param $parentContentId
     * @param $contentId
     * @param $language
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($tableName, $parentContentId, $contentId, $language)
    {
        $className = Yii::$app->contentTree->getClassName($tableName);

        $translateClass = $className::getTranslateModelClass();
        $translateModel = new $translateClass();


        $translateModelByLanguage = $this->findModel($className, $translateModel, $contentId, $language);

        $translateModelByLanguage->parentContentId = $parentContentId;
        $translateModelByLanguage->language = $language;

        $transaction = Yii::$app->db->beginTransaction();

        if ($translateModelByLanguage->load(Yii::$app->request->post()) && $translateModelByLanguage->save()) {
            $transaction->commit();
            if (intval(Yii::$app->request->post('go_to_parent'))) {
                $tree = ContentTree::find()->byId($parentContentId)->one();
                return $this->redirect($tree->getFullUrl());
            }
            $tree = ContentTree::find()->byRecordIdTableName($contentId, $tableName)->one();
            return $this->redirect($tree->getFullUrl());
        }

        $transaction->rollBack();
        $tree = ContentTree::find()->byId($parentContentId)->one();
        $breadCrumbs = $tree ? $tree->getBreadCrumbs() : [];
        return $this->render(
            '@backend/views/content-tree/update', [
            'model' => $translateModelByLanguage,
            'tableName' => $tableName,
            'breadCrumbs' => $breadCrumbs,
            'url' => $tree ? $tree->getFullUrl() : '/'
        ]);
    }

    /**
     * @param $tableName
     * @param $contentTreeId
     * @param $id
     * @return \yii\web\Response
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionDelete($tableName, $contentTreeId, $id)
    {
        $ClassName = Yii::$app->contentTree->getClassName($tableName);
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
            /** @var BaseModel $baseModel */
            $baseModel = $ClassName::find()->byId($id)->one();
            $tree = ContentTree::find()->byId($contentTreeId)->one();
            $tree->deleted_at = time();
            $tree->deleted_by = Yii::$app->user->id;

            if (!$tree->link_id) {
                $baseModel->deleted_at = time();
                $baseModel->deleted_by = Yii::$app->user->id;
                $baseModel->save();
            }

            $children = $tree->children()->notDeleted()->all();

            $parent = $tree->getParent();

            foreach ($children as $child) {
                if (!$child->link_id) {
                    /** @var BaseModel $childBaseModel */
                    $ClassName = Yii::$app->contentTree->getClassName($child->table_name);
                    $childBaseModel = $ClassName::find()->byId($child->record_id)->one();
                    $childBaseModel->deleted_at = time();
                    $childBaseModel->deleted_by = Yii::$app->user->id;
                    $childBaseModel->save();
                }
                $child->deleted_at = time();
                $child->deleted_by = Yii::$app->user->id;
                $child->save();
            }

            $tree->save();
            $transaction->commit();
            $category = $ClassName::getFormattedTableName();
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'group' => TimelineEvent::GROUP_CONTENT,
                'category' => $category,
                'event' => TimelineEvent::EVENT_DELETE,
                'record_id' => $id,
                'record_name' => $tree->getActualItemActiveTranslation()->name,
                'data' => ['old' => $baseModel->activeTranslation->getData()],
                'createdBy' => Yii::$app->user->id
            ]));

        return $this->redirect($parent->getFullUrl());
    }

    /**
     * @param $tableName
     * @param $contentId
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionArchive($tableName, $contentId)
    {
        $ClassName = Yii::$app->contentTree->getClassName($tableName);
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {

            /** @var BaseModel $baseModel */
            $baseModel = $ClassName::find()->byId($contentId)->one();
            $baseModel->deleted_at = time();
            $baseModel->save();
            $tree = ContentTree::find()->byRecordIdTableName($contentId, $tableName)->one();
            $tree->deleted_at = time();
            $tree->deleted_by = Yii::$app->user->id;
            $tree->save();

            $transaction->commit();
            $tableName = $ClassName::tableName();
            $category = str_replace('}}', '', str_replace('{{%', '', $tableName));
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'group' => TimelineEvent::GROUP_CONTENT,
                'category' => $category,
                'event' => TimelineEvent::EVENT_ARCHIVE,
                'record_id' => $contentId,
                'record_name' => $baseModel->getTitle(),
                'data' => ['old' => $baseModel->activeTranslation->getData()],
                'createdBy' => Yii::$app->user->id
            ]));
        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return $this->redirect($tree->getFullUrl());
    }

    public function actionSwap()
    {
        $request = Yii::$app->request;
        $prev = intval($request->post('prev'));
        $next = intval($request->post('next'));
        $element = intval($request->post('element'));

        if ($element > 0 && $tree = ContentTree::find()->byId($element)->one()) {
            if ($prev > 0 && $prevTree = ContentTree::find()->byId($prev)->one()) {
                if ($tree->insertAfter($prevTree)) {
                    $this->swapTimelineEvent($tree);
                    return true;
                }
            } else {
                if ($next > 0 && $nextTree = ContentTree::find()->byId($next)->one()) {
                    if ($tree->insertBefore($nextTree)) {
                        $this->swapTimelineEvent($tree);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return bool
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateView()
    {
        $id = intval(Yii::$app->request->post('id'));
        $view = Yii::$app->request->post('value');

        $tree = ContentTree::find()->byId($id)->one();

        if ($tree) {
            $data = ['old' => ['view' => $tree->view ? $tree->view : Yii::t('backend', 'Default')]];

            if (Yii::$app->contentTree->viewExists($tree->table_name, $view)) {
                $tree->view = $view;
            } else {
                $tree->view = null;
            }
            $data['new'] = ['view' => $tree->view ? $tree->view : Yii::t('backend', 'Default')];
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'group' => TimelineEvent::GROUP_CONTENT,
                'category' => TimelineEvent::CATEGORY_CONTENT_TREE,
                'event' => TimelineEvent::EVENT_DESIGN_CHANGE,
                'record_id' => $id,
                'record_name' => $tree->getActualItemActiveTranslation()->name,
                'data' => $data,
                'createdBy' => Yii::$app->user->id
            ]));
            return $tree->save();
        }
        return false;
    }

    /**
     * @return bool
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionUpdateHide()
    {
        $id = intval(Yii::$app->request->post('id'));
        $hide = intval(Yii::$app->request->post('value'));

        $tree = ContentTree::find()->byId($id)->one();

        if ($tree) {
            $data = ['old' => ['hide' => $tree->hide ? $tree->hide : Yii::t('backend', 'Default')]];

            $tree->hide = $hide;

            $data['new'] = ['hide' => $tree->hide ? $tree->hide : Yii::t('backend', 'Default')];
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'group' => TimelineEvent::GROUP_CONTENT,
                'category' => TimelineEvent::CATEGORY_CONTENT_TREE,
                'event' => $hide == 1 ? TimelineEvent::SHOW : TimelineEvent::HIDE,
                'record_id' => $id,
                'record_name' => $tree->getActualItemActiveTranslation()->name,
                'data' => $data,
                'createdBy' => Yii::$app->user->id
            ]));
            return $tree->save();
        }
        return false;
    }

    public function actionMenu()
    {
        $this->enableCsrfValidation = false;

        if (Yii::$app->request->isPost) {
            $showInMenu = array_map('intval', Yii::$app->request->post('menu_ids', []));

            $id = intval(Yii::$app->request->post('id'));
            $tree = ContentTree::find()->byId($id)->linkedIdIsNull()->one();
            if ($tree && $menuModel = ContentTreeMenu::find()->byContentTreeId($tree->id)->all()) {
                $menu = ArrayHelper::map($menuModel, 'menu_id', 'menu_id');
                $del = [];

                foreach (array_diff($menu, $showInMenu) as $deleted) {
                    array_push($del, $deleted);
                }

                ContentTreeMenu::deleteAll(['content_tree_id' => $tree->id, 'menu_id' => $del]);
                $add = [];

                foreach (array_diff($showInMenu, $menu) as $added) {
                    array_push($add, $added);
                }
                foreach ($add as $menuItem) {

                    $menuModel = new ContentTreeMenu();
                    $menuModel->menu_id = intval($menuItem);
                    $menuModel->content_tree_id = $tree->id;
                    if (!$menuModel->save()) {
                        return false;
                    }
                }
            } else {
                if ($tree) {
                    foreach ($showInMenu as $menuItem) {
                        $menuModel = new ContentTreeMenu();
                        $menuModel->menu_id = $menuItem;
                        $menuModel->content_tree_id = $tree->id;
                        if (!$menuModel->save()) {
                            return false;
                        }
                    }
                } else {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionTree()
    {
        $id = intval(Yii::$app->request->post('key', 0));
        $tableNames = (Yii::$app->request->post('table_names', null));

        $tree = ContentTree::getItemsAsTreeForLink($id, $tableNames);
        return json_encode($tree);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionTreeForMove()
    {
        $id = intval(Yii::$app->request->post('key', 0));
        $tableNames = (Yii::$app->request->post('table_names', null));

        $tree = ContentTree::getItemsAsTreeForLink($id, $tableNames);
        return json_encode($tree);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\base\Exception
     * @throws NotFoundHttpException
     */
    public function actionUserLogin($id)
    {
        $url = Yii::$app->request->get('url', '');
        $id = Yii::$app->request->get('id', '');
        $model = $this->findUserModel($id);
        $tokenModel = UserToken::create(
            $model->getId(),
            UserToken::TYPE_LOGIN_PASS,
            60
        );

        return $this->redirect(
            Yii::$app->urlManagerFrontend->createAbsoluteUrl(['user/sign-in/login-by-pass', 'token' => $tokenModel->token, 'url' => $url])
        );
    }

    /**
     * @return string
     * @property ContentTree $parentTree
     */
    public function actionLinkTree()
    {
        $res = ['code' => 1];
        $treeId = intval(Yii::$app->request->post()['tree']);
        $parentTree = ContentTree::find()->byId($treeId)->linkedIdIsNull()->one();
        if ($parentTree) {
            if (isset(Yii::$app->request->post()['ids']) && is_array(Yii::$app->request->post()['ids'])) {
                foreach (Yii::$app->request->post()['ids'] as $id) {
                    $linkedParentTree = ContentTree::find()->byId(intval($id))->linkedIdIsNull()->one();
                    if ($linkedParentTree) {
                        $linkedTree = new ContentTree();
                        $linkedTree->link_id = $linkedParentTree->id;
                        $linkedTree->record_id = $linkedParentTree->record_id;
                        $linkedTree->table_name = $linkedParentTree->table_name;
                        if (!$linkedTree->appendTo($parentTree)) {
                            return json_encode(['code' => 0, 'message' => 'Could Not Prepend To Parent Node']);
                        }
                    } else {
                        $res = ['code' => 0, 'message' => 'Tree Not Found'];
                    }
                }
            }
        } else {
            $res = ['code' => 0, 'message' => 'Tree Not Found'];
        }
        return json_encode($res);
    }


    public function actionMoveTree()
    {
        $res = ['code' => 1];
        $post = Yii::$app->request->post();
        if (isset($post['moved']) && is_array($post['moved'])) {
            foreach ($post['moved'] as $moved) {
                $movedTree = ContentTree::find()->byId(intval($moved))->linkedIdIsNull()->one();
                if ($movedTree && isset($post['prepend_to']) && is_array($post['prepend_to'])) {
                    foreach ($post['prepend_to'] as $prependTo) {
                        $appendToTree = ContentTree::find()->byId(intval($prependTo))->linkedIdIsNull()->one();
                        if (!($appendToTree && $movedTree->appendTo($appendToTree))) {
                            $res = ['code' => 0, 'message' => 'Could Not Prepend To Parent Node'];
                        } else {
                            $newMovedTree = ContentTree::find()->byId(intval($moved))->linkedIdIsNull()->one();
                            $newMovedTree->updateFullAliasPathWithChild();
                        }
                    }
                } else {
                    $res = ['code' => 0, 'message' => 'Tree Not Found'];
                }
            }
        } else {
            $res = ['code' => 0, 'message' => 'Bad Request'];
        }

        return json_encode($res);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUserModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $basicModelClass
     * @param $translateModel
     * @param $contentId
     * @param $language
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($basicModelClass, $translateModel, $contentId, $language)
    {
        if (($model = $translateModel::find()->findByObjectIdAndLanguage($contentId, $language,
                $translateModel->getForeignKeyNameOnModel())->one()) !== null) {
            return $model;
        } else {
            if (($model = $basicModelClass::find()->byId($contentId)->one()) !== null) {
                $key = $translateModel->getForeignKeyNameOnModel();
                $translateModel->$key = intval($contentId);
                return $translateModel;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }

    /**
     * @param \apollo11\lobicms\models\ContentTree $tree
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     */
    private function swapTimelineEvent($tree)
    {
        $category = $tree->table_name;
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'group' => TimelineEvent::GROUP_CONTENT,
            'category' => $category,
            'event' => TimelineEvent::EVENT_POSITION,
            'record_id' => $tree->record_id,
            'record_name' => $tree->getActualItem()->activeTranslation->name,
            'data' => ['alias' => $tree->getActualItem()->activeTranslation->alias],
            'createdBy' => Yii::$app->user->id
        ]));
    }

    public function actionDeleteFileItem()
    {
        return true;
    }
}
