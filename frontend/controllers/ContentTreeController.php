<?php
/**
 * User: zura
 * Date: 6/19/18
 * Time: 7:01 PM
 */

namespace frontend\controllers;

use apollo11\lobicms\models\BaseModel;
use frontend\models\ContentTree;
use Yii;
use apollo11\lobicms\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * Class ContentTreeController
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package frontend\controllers
 */
class ContentTreeController extends Controller
{
    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $contentTreeItem = $this->findContentTreeByFullPath();

//        $segments = explode('/', $nodes);
//        $alias = end($segments);
//        $contentTreeItem = $this->findContentTree($alias);
        $model = $contentTreeItem->getModel();

        if ($contentTreeItem->record_id !== -1 && !$model) {
            throw new NotFoundHttpException("Content is not editable");
        }

        $this->getView()->contentTreeObject = $contentTreeItem;
        return $this->render('index', [
            'contentTreeItem' => $contentTreeItem,
            'model' => $model,
        ]);
    }

    public function actionEditContent()
    {
        $language = \Yii::$app->request->post('language');
        $contentId = \Yii::$app->request->post('content-id');
        $attribute = \Yii::$app->request->post('attribute');
        $type = \Yii::$app->request->post('type');
        $contentText = \Yii::$app->request->post('content');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $content = $this->findContentTreeById($contentId);

        /** @var BaseModel $model */
        $model = $content->getModel();
        $translation = $model->getTranslation()->andWhere(['language' => $language])->one();

        if (!$model || !$translation) {
            throw new NotFoundHttpException();
        }
        if ($type != 'image') {
            $translation->$attribute = $type == 'rich-text' ? $contentText : strip_tags($contentText);
        }
        if ($translation->save()) {
            return [
                'success' => true
            ];
        }

        return [
            'success' => false
        ];
    }

    public function actionHideSection()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $contentTree = ContentTree::find()->byId(intval(Yii::$app->request->post('contentId')))->one();
        $contentTree->hide = intval(Yii::$app->request->post('state'));
        /** @var BaseModel $model */

        if ($contentTree->save()) {
            return [
                'success' => true
            ];
        }

        return [
            'success' => false
        ];
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $alias
     * @return array|ContentTree|null
     * @throws NotFoundHttpException
     */
    protected function findContentTree($alias)
    {
        if (!($contentTree = ContentTree::find()->byAlias($alias)->one())) {
            throw new NotFoundHttpException("Incorrect alias given");
        }
        return $contentTree;
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $id
     * @return array|ContentTree|null
     * @throws NotFoundHttpException
     */
    protected function findContentTreeById($id)
    {
        if (!($contentTree = ContentTree::find()->byId($id)->one())) {
            throw new NotFoundHttpException();
        }
        return $contentTree;
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return array|ContentTree|null
     * @throws NotFoundHttpException
     */
    protected function findContentTreeByFullPath()
    {
        $contentTree = null;
        $aliasPath = Yii::$app->getCurrentAlias();
        if ($aliasPath) {
            $contentTree = ContentTree::find()->byAliasPath($aliasPath)->notHidden()->notDeleted()->one();
        }
        if ($contentTree) {
            return $contentTree;
        }

        if (!($contentTree = ContentTree::find()->byIdAndLanguage(Yii::$app->defaultContentId, Yii::$app->language)->notHidden()->notDeleted()->one())) {
            throw new NotFoundHttpException("Content does not exist for [ID = 2], [language = " . \Yii::$app->language . "]");
        }
        $this->getView()->contentTreeObject = $contentTree;
        return $contentTree;
    }

    /**
     *
     * @throws \Exception
     */
    public function actionGetTree()
    {
        $tree = ContentTree::getItemsAsTreeForLink(null, ['page']);
        return json_encode($tree);
    }

    /**
     * @return array
     */
    public function actionLinkTree()
    {
        $res = ['success' => false];
        $parentId = intval(Yii::$app->request->post('parentId'));
        $currentLinkId = intval(Yii::$app->request->post('linkId'));
        $parentLinkId = intval(Yii::$app->request->post('parentLinkId'));

        $parentContentTree = ContentTree::find()->byId($parentId)->linkedIdIsNull()->one();
        $linkedParentTree = ContentTree::find()->byId($parentLinkId)->linkedIdIsNull()->one();

        if ($parentContentTree && $linkedParentTree) {
            $linkedTree = new ContentTree();
            $linkedTree->link_id = $linkedParentTree->id;
            $linkedTree->record_id = $linkedParentTree->record_id;
            $linkedTree->table_name = $linkedParentTree->table_name;
            if ($linkedTree->appendTo($parentContentTree)) {
                $currentLinkTree = ContentTree::find()->byId($currentLinkId)->one();
                $currentLinkTree->markDelete();
                $res = ['success' => true, 'url' => $linkedParentTree->getUrl()];
            }
        }

        return json_encode($res);
    }

}
