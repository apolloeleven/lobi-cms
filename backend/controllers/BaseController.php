<?php

namespace backend\controllers;

use backend\models\ContentTree;
use common\models\BaseModel;
use Yii;

class BaseController extends \intermundia\yiicms\controllers\BaseController
{

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $tableName
     * @param $contentTreeId
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($tableName, $contentTreeId, $id)
    {
        $ClassName = Yii::$app->contentTree->getClassName($tableName);
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        /** @var BaseModel $baseModel */
        $baseModel = $ClassName::find()->byId($id)->one();
        $tree = ContentTree::find()->byId($contentTreeId)->one();
        $parent = $tree->getParent();

        $tree->deleteWithChildren();

        if (!$tree->link_id) {
            $baseModel->delete();
        }

        $transaction->commit();

        return $this->redirect($parent->getFullUrl());
    }
}
