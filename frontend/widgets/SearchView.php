<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 7/9/18
 * Time: 11:36 AM
 */

namespace frontend\widgets;


use apollo11\lobicms\models\ContentTree;
use apollo11\lobicms\models\Search;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

class SearchView extends ListView
{
    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @var ArrayDataProvider
     */
    public $dataProvider;
    public $searchableWord;

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->dataProvider->allModels = self::processSearchModels($this->dataProvider->allModels);
        parent::init();
    }

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param Search[] $models
     * @return array
     */
    private static function processSearchModels($models)
    {
        $allModels = [];
        foreach ($models as $model) {
            /** @var Search $model */
            $linkedContentTrees = $model->linkedContentTrees;
            if ($model->contentTree) {
                $linkedContentTrees[] = $model->contentTree;
            }

            foreach ($linkedContentTrees as $contentTree) {
                $page = $contentTree->getPage();
                if (!$page) {
                    continue;
                }

                if (isset($allModels[$page->id])){
                    continue;
                }
                $allModels[$page->id] = [$page, $model];
            }
        }
        return $allModels;
    }

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
        foreach ($this->dataProvider->getModels() as $modelItem) {

            /** @var ContentTree $contentTreePage */
            list($contentTreePage, $model) = $modelItem;

            $titleHeader = Html::tag('h3', Html::a($contentTreePage->getName(), $contentTreePage->getUrl()));
//                $contentDiv = Html::tag('div', $model->content);
            $contentDiv = Html::tag('div', $this->getSearchResult($this->searchableWord, $model->content));
            $searchCont[] = Html::tag('div', $titleHeader . $contentDiv,
                ['class' => 'search-list-item']);

        }

        return $searchCont;
    }

    public function getSearchResult($keyword, $text)
    {
        // Find search keyword's position
        $kPos = stripos($text, $keyword);
        // Find any of (. ! ?) before search keyword. If not found take start
        $startStr = substr($text, 0, $kPos);
        $maxStartPos = 0;
        $endChars = ['. ', '! ', '? '];
        foreach ($endChars as $endChar) {
            $sPos = strrpos($startStr, $endChar);
            if ($sPos && $sPos > $maxStartPos) {
                $maxStartPos = $sPos;
            }
        }
        // Find any of (. ! ?) after search keyword. Closest needed.
        $minEndPos = strlen($text) - 1;

        $spaceCount = 0;
        $sePos = $kPos ?: 1;
        // count 50 words
        while ($sePos && ($spaceCount < 31)) {
            $sePos = strpos($text, ' ', $sePos + 1);
            $spaceCount++;
        }
        // if string is longer, try to find (. ! ?)
        if ($sePos) {
            foreach ($endChars as $endChar) {
                $ePos = strpos($text, $endChar, $sePos);
                if ($ePos && $ePos < $minEndPos) {
                    $minEndPos = $ePos;
                }
            }
            // if no (. ! ?) found, count 20 more words
            if ($minEndPos == (strlen($text) - 1)) {
                while ($sePos && ($spaceCount < 71)) {
                    $sePos = strpos($text, ' ', $sePos + 1);
                    $spaceCount++;
                }
            } else {
                $sePos = false;
            }
            // if string is still longer, cut at last found space
            if ($sePos) {
                $minEndPos = $sePos;
            }
        }
        // Finally cut the substring and wrap keyword in span with colored class
        $str = substr(
            $text,
            $maxStartPos == 0 ? $maxStartPos : $maxStartPos + 2,
            $maxStartPos == 0 ? $minEndPos - $maxStartPos + 1 : $minEndPos - $maxStartPos - 1
        );
        $str = str_ireplace(
            $keyword,
            '<span class="search-highlighted">' . $keyword . '</span>',
            $str
        );
        // if sentence is cut, add three dots
        if (!in_array(substr($str, -1) . ' ', $endChars)) {
            $str .= "...";
        }
        return $str;
    }

}
