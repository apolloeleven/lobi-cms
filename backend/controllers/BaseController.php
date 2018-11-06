<?php

namespace backend\controllers;

use apollo11\lobicms\models\ContentTree;
use apollo11\lobicms\models\ContentTreeMenu;
use Yii;
use yii\helpers\ArrayHelper;

class BaseController extends \apollo11\lobicms\controllers\BaseController
{
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

                $deletedItems = ContentTreeMenu::find()->byMenuId($del)->byContentTreeId($tree->id)->all();

                foreach ($deletedItems as $deletedItem) {
                    Yii::$app->db
                        ->createCommand("UPDATE content_tree_menu SET position=position-1 
                                     WHERE position > '$deletedItem->position' AND 
                                     menu_id = '$deletedItem->menu_id'
                                     ")
                        ->execute();
                }
                ContentTreeMenu::deleteAll(['content_tree_id' => $tree->id, 'menu_id' => $del]);
                $add = [];

                foreach (array_diff($showInMenu, $menu) as $added) {
                    array_push($add, $added);
                }

                foreach ($add as $menuItem) {
                    $newPosition = ContentTreeMenu::find()->byMenuId($menuItem)->orderBy(['position' => SORT_DESC])->one();
                    $menuModel = new ContentTreeMenu();
                    $menuModel->menu_id = intval($menuItem);
                    $menuModel->content_tree_id = $tree->id;
                    $menuModel->position = $newPosition->position + 1;
                    if (!$menuModel->save()) {
                        return false;
                    }
                }
            } else {
                if ($tree) {
                    foreach ($showInMenu as $menuItem) {
                        $newPosition = ContentTreeMenu::find()->byMenuId($menuItem)->orderBy(['position' => SORT_DESC])->one();
                        $menuModel = new ContentTreeMenu();
                        $menuModel->menu_id = $menuItem;
                        $menuModel->content_tree_id = $tree->id;
                        $menuModel->position = $newPosition->position + 1;
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

}
