<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 7/9/18
 * Time: 11:36 AM
 */

namespace frontend\widgets;


use frontend\models\ContentTree;
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

    public function init()
    {
        $uniquePages = [];
        $allModels = $this->dataProvider->allModels;
        $allModels = array_filter($allModels, function ($model) use (&$uniquePages) {
            /** @var ContentTree $contentTree */
            $contentTree = $model->contentTree;
            if (!$contentTree->activeTranslation->name && !$model->content) {
                return false;
            }
            $page = $contentTree->getPage();
            if (!$page || isset($uniquePages[$page->id])) {
                return false;
            }
            $uniquePages[$page->id] = $page;
            return true;
        });
        $this->dataProvider->allModels = $allModels;
        parent::init();
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
        foreach ($this->dataProvider->getModels() as $model) {
            /** @var ContentTree $contentTree */
            $contentTree = $model->contentTree;

            $page = $contentTree->getPage();
            $titleHeader = Html::tag('h3', Html::a($page->getName(), $page->getUrl()));
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
