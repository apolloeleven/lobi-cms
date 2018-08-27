<?php
/**
 * User: zura
 * Date: 6/19/18
 * Time: 7:01 PM
 */

namespace backend\controllers;

use backend\models\ContentTree;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * Class ContentTreeController
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package backend\controllers
 */
class ContentTreeController extends Controller
{
    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $nodes
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($nodes = '')
    {
        if (!$nodes) {
            $nodes = \Yii::$app->defaultAlias;
        }

        $alias_path = preg_replace('@^website\/@', '', $nodes);
        $contentTreeItem = $this->findContentTreeByFullPath($alias_path);


        $model = $contentTreeItem->getModel();
        if ($contentTreeItem->record_id !== -1 && !$model) {
            throw new NotFoundHttpException("Content is not editable");
        }

        return $this->render('index', [
            'contentTreeItem' => $contentTreeItem
        ]);
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
        if (!($contentTree = ContentTree::find()->byAlias($alias)->notDeleted()->one())) {
            throw new NotFoundHttpException("Incorrect alias given");
        }
        return $contentTree;
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $aliasPath
     * @return \apollo11\lobicms\models\ContentTree|array|null
     * @throws NotFoundHttpException
     */
    protected function findContentTreeByFullPath($aliasPath)
    {
        if (!($contentTree = ContentTree::find()->byAliasPath($aliasPath)->notDeleted()->one())) {
            throw new NotFoundHttpException("Incorrect alias Path given");
        }
        return $contentTree;
    }
}
