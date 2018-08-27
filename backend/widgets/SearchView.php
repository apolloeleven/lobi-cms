<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 7/9/18
 * Time: 11:36 AM
 */

namespace backend\widgets;


use Yii;
use yii\helpers\Html;
use yii\widgets\BaseListView;

class SearchView extends BaseListView
{
    public $searchableWord;

    /**
     * Renders the data models.
     * @return string the rendering result.
     */
    public function renderItems()
    {
        return Html::tag('div', implode("\n", $this->renderSearch()));
    }

    public function renderSearch()
    {

        foreach ($this->dataProvider->getModels() as $model) {
            if (!empty($model->contentTree->activeTranslation->name) && !empty($model->content)) {
                $path = '';
                $titleUrl = Html::a($model->contentTree->activeTranslation->name, $model->contentTree->getFullUrl());
                $icon = '&nbsp&nbsp<i class="fa ' . Yii::$app->contentTree->getIcon($model->table_name) . '"></i> ';

                $type = Html::tag('h6', implode(" ", array_map('ucfirst', explode('_', $model->attribute))) . ':');

                foreach (explode('/', $model->contentTree->activeTranslation->alias_path) as $item) {
                    $path .= $item . ' / ';
                }

                $full_path = Html::tag('h6', rtrim($path, " / "), ['style' => 'font-weight: bold;']);
                $titleHeader = Html::tag('h3', $titleUrl . $icon);
                $contentSpan = Html::tag('span', $model->content, ['class' => 'search-cont']);
                $contentDiv = Html::tag('div', $contentSpan);
                $view = Html::a('view / ', $model->contentTree->getFullUrl());
                $update = Html::a('update', $model->contentTree->getModel()->getUpdateUrl());
                $searchCont[] = Html::tag('div', $titleHeader . $full_path . $type . $contentDiv . $view . $update, ['class' => 'raw search-content', 'style' => 'margin-bottom:40px;']);
            }
        }

        return $searchCont;
    }

}
