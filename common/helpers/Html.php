<?php
/**
 * User: zura
 * Date: 11/29/18
 * Time: 5:02 PM
 */

namespace common\helpers;

use intermundia\yiicms\models\BaseModel;
use intermundia\yiicms\models\FileManagerItem;
use common\models\ContentText;
use yii\helpers\ArrayHelper;

/**
 * Class Html
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package ${NAMESPACE}
 */
class Html
{
    /**
     * Generate picture tag with different sources
     *
     * @param ContentText $model
     * @param $attribute
     * @param array $options
     * @return string
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public static function picture(ContentText $model, $attribute, $options = [])
    {
        /** @var FileManagerItem[] $images */
        $images = $model->activeTranslation->{$attribute};
        $imgSources = [];
        foreach ($images as $image) {
            array_push($imgSources, $image->getUrl());
        }
        $extraSmallImg = '';
        $smallImg = '';
        $mediumImg = '';
        $largeImg = '';
        $extraSmallRetinaImg = '';
        $smallRetinaImg = '';
        $mediumRetinaImg = '';
        $largeRetinaImg = '';
        $mediaInnerText = "only screen and (max-width: {{size}}px) and (-webkit-min-device-pixel-ratio: 2)," .
            "only screen and (max-width: {{size}}px) and (   min--moz-device-pixel-ratio: 2)," .
            "only screen and (max-width: {{size}}px) and (     -o-min-device-pixel-ratio: 2/1)," .
            "only screen and (max-width: {{size}}px) and (        min-device-pixel-ratio: 2)," .
            "only screen and (max-width: {{size}}px) and (                min-resolution: 192dpi)," .
            "only screen and (max-width: {{size}}px) and (                min-resolution: 2dppx)";

        foreach ($imgSources as $url) {
            if (strpos($url, "-extra-small.")) {
                $extraSmallImg = $url;
            } else {
                if (strpos($url, "-extra-small@2x.")) {
                    $extraSmallRetinaImg = $url;
                } else {
                    if (strpos($url, "-small.")) {
                        $smallImg = $url;
                    } else {
                        if (strpos($url, "-small@2x.")) {
                            $smallRetinaImg = $url;
                        } else {
                            if (strpos($url, "-medium.")) {
                                $mediumImg = $url;
                            } else {
                                if (strpos($url, "-medium@2x.")) {
                                    $mediumRetinaImg = $url;
                                } else {
                                    if (strpos($url, "-large.")) {
                                        $largeImg = $url;
                                    } else {
                                        if (strpos($url, "-large@2x.")) {
                                            $largeRetinaImg = $url;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $sources =
            "<source media='" . str_replace('{{size}}', 767, $mediaInnerText) . "' srcset='${extraSmallRetinaImg}'/>" .
            "<source media='(max-width: 767px)' srcset='${extraSmallImg}'/>" .

            "<source media='" . str_replace('{{size}}', 991, $mediaInnerText) . "' srcset='${smallRetinaImg}'/>" .
            "<source media='(max-width: 991px)' srcset='${smallImg}'/>" .

            "<source media='" . str_replace('{{size}}', 1200, $mediaInnerText) . "' srcset='${mediumRetinaImg}'/>" .
            "<source media='(max-width: 1200px)' srcset='${mediumImg}'/>" .

            "<source media='" . str_replace('(max-width: {{size}}px) and', '',
                $mediaInnerText) . "' srcset='${largeRetinaImg}'/>" .
            "<img alt='{$model->activeTranslation->alt_text}' src='${largeImg}'/>";

        return \yii\bootstrap\Html::tag('picture', $sources, $options);
    }

    /**
     * Generate style tag and set background images for given item
     *
     * @param BaseModel $model
     * @param $attribute
     * @param array $options
     * @return string
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function backgroundImage(BaseModel $model, $attribute, $options = [])
    {

        $extraSmallImg = '';
        $smallImg = '';
        $mediumImg = '';
        $largeImg = '';
        $extraSmallRetinaImg = '';
        $smallRetinaImg = '';
        $mediumRetinaImg = '';
        $largeRetinaImg = '';
        $mediaInnerText = "only screen and (max-width: {{size}}px) and (-webkit-min-device-pixel-ratio: 2)," .
            "only screen and (max-width: {{size}}px) and (   min--moz-device-pixel-ratio: 2)," .
            "only screen and (max-width: {{size}}px) and (     -o-min-device-pixel-ratio: 2/1)," .
            "only screen and (max-width: {{size}}px) and (        min-device-pixel-ratio: 2)," .
            "only screen and (max-width: {{size}}px) and (                min-resolution: 192dpi)," .
            "only screen and (max-width: {{size}}px) and (                min-resolution: 2dppx)";

        /** @var FileManagerItem[] $images */
        $images = $model->activeTranslation->{$attribute};
        if (!$images) {
            return '';
        }
        foreach ($images as $image) {
            $url = $image->getUrl();
            if (strpos($url, "-extra-small.")) {
                $extraSmallImg = $url;
            } elseif (strpos($url, "-extra-small@2x.")) {
                $extraSmallRetinaImg = $url;
            } elseif (strpos($url, "-small.")) {
                $smallImg = $url;
            } elseif (strpos($url, "-small@2x.")) {
                $smallRetinaImg = $url;
            } elseif (strpos($url, "-medium.")) {
                $mediumImg = $url;
            } elseif (strpos($url, "-medium@2x.")) {
                $mediumRetinaImg = $url;
            } elseif (strpos($url, "-large.")) {
                $largeImg = $url;
            } elseif (strpos($url, "-large@2x.")) {
                $largeRetinaImg = $url;
            }
        }

        $contentTreeItem = $model->contentTree;
        $sources = '';
        $sources .= PHP_EOL . "
            #content_$contentTreeItem->id{
                background-image: url('$largeImg')
            }
        ";
        $sources .= PHP_EOL . "@media " . str_replace('(max-width: {{size}}px) and', '', $mediaInnerText) . "{
            #content_$contentTreeItem->id{
                background-image: url('$largeRetinaImg')
            }
        }";
        $sources .= PHP_EOL . "@media (max-width: 1200px) {
            #content_$contentTreeItem->id{
                background-image: url('$mediumImg')
            }
        }";
        $sources .= PHP_EOL . "@media " . str_replace('{{size}}', 1200, $mediaInnerText) . "{
            #content_$contentTreeItem->id{
                background-image: url('$mediumRetinaImg')
            }
        }";
        $sources .= PHP_EOL . "@media (max-width: 991px) {
            #content_$contentTreeItem->id{
                background-image: url('$smallImg')
            }
        }";
        $sources .= PHP_EOL . "@media " . str_replace('{{size}}', 991, $mediaInnerText) . "{
            #content_$contentTreeItem->id{
                background-image: url('$smallRetinaImg')
            }
        }";
        $sources .= PHP_EOL . "@media (max-width: 767px) {
            #content_$contentTreeItem->id{
                background-image: url('$extraSmallImg')
            }
        }";
        $sources .= PHP_EOL . "@media " . str_replace('{{size}}', 767, $mediaInnerText) . "{
            #content_$contentTreeItem->id{
                background-image: url('$extraSmallRetinaImg')
            }
        }";


        return \yii\bootstrap\Html::tag('style', $sources, $options);
    }

    /**
     * @param $modelOrFileManagerItem
     * @param null $attribute
     * @param array $options
     * @return string
     */
    public static function video($modelOrFileManagerItem, $attribute = null, $options = [])
    {
        /** @var FileManagerItem[] $videos */

        if ($modelOrFileManagerItem && $modelOrFileManagerItem instanceof BaseModel) {
            $videos = $modelOrFileManagerItem->activeTranslation->{$attribute};
        } else {
            $videos = [$modelOrFileManagerItem];
        }
        $sources = [];
        foreach ($videos as $video) {
            $sources[] = \yii\bootstrap\Html::tag('source', '', [
                'src' => $video ? $video->getUrl() : '',
                'type' => $video ? $video->type : ''
            ]);
        }
        return \yii\bootstrap\Html::tag('video', implode(PHP_EOL, $sources), $options);
    }
}