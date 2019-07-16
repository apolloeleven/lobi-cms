<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 7/9/18
 * Time: 11:36 AM
 */

namespace frontend\widgets;


use intermundia\yiicms\models\Search;
use frontend\models\ContentTree;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\StringHelper;
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
        $this->dataProvider->allModels = self::processSearchModels($this->dataProvider->allModels);
        parent::init();
    }

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

                if (isset($allModels[$page->id])) {
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

            list($contentTreePage, $model) = $modelItem;

            $titleHeader = Html::tag('h3', Html::a($contentTreePage->getName(), $contentTreePage->getUrl()));
//                $contentDiv = Html::tag('div', $model->content);
            $contentDiv = Html::tag('div', $this->myDetect($this->searchableWord, $model->content));
            $searchCont[] = Html::tag('div', $titleHeader . $contentDiv,
                ['class' => 'search-list-item']);

        }

        return $searchCont;
    }

    /**
     *
     *
     * @param $originalKeyword
     * @param $originalText
     * @return string|string[]|null
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function myDetect($originalKeyword, $originalText)
    {

        $text = strip_tags(strtolower($originalText));
        $keyword = strtolower($originalKeyword);
        $firstMatchPosition = strpos($text, $keyword);

        $startPos = $firstMatchPosition;
        $endPos = $firstMatchPosition + strlen($keyword);
        while (is_numeric($startPos) && $startPos >= 0 && !in_array($text[$startPos], ['.', '?', '!', ';'])) {
            $startPos--;
        }
        while ($endPos < strlen($text) && !in_array($text[$endPos], ['.', '?', '!', ';'])) {
            $endPos++;
        }

//        echo '<pre>';
//        var_dump($originalText);
//        echo '</pre>';

        $text = StringHelper::truncateWords(substr($originalText, $startPos + 1), 30);

        return preg_replace("/($originalKeyword)/i", '<span class="search-highlighted">$1</span>',
            $text);

    }

    /**
     *
     *
     * @param $keyword
     * @param $text
     * @return string
     * @author Dato Apkhazashvili
     */
    public function detecttext($keyword, $text)
    {
        $finalText = '';
        $i = 0;
        $m = [];
        while (stripos($text, $keyword, $i) !== false) {
            $i = stripos($text, $keyword, $i);
            $text = substr_replace($text, "<b>", $i, 0) . "<br>";
            $text = substr_replace($text, "</b>", $i + strlen($keyword) + 3, 0) . "<br>";
            $i += 4;
        }
        $k = 0;
        $n = 0;
        $j = 0;
        for ($i = 0; $i < strlen($text); $i++) {
            if ($text[$i] === " ") {
                $k++;
            }
            if ($text[$i] === "." || $text[$i] === "?" || $text[$i] == "!") {
                if (stripos($text, $keyword, $j) < $i) {
                    $h = $j;
                    if ($k >= 50) {
                        while ($h <= $i) {
                            $finalText .= $text[$h];
                            $h++;
                        }
                        $finalText .= "<br>";
                    } else {
                        $k = 0;
                        while ($h < strlen($text)) {
                            $finalText .= $text[$h];
                            $h++;
                            if ($text[$h] === " ") {
                                $k++;
                            }
                            if ($k === 50) {
                                break;
                            }
                        }
                        $finalText .= "<br>";
                    }
                }
                $j = $i + 1;
                $k = 0;
            }
        }
        return $finalText;
    }

    /**
     *
     *
     * @param $keyword
     * @param $text
     * @return bool|mixed|string
     * @author Zura Kupatadze
     */
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
