<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $view
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PageTranslation[] $translations
 * @property PageTranslation $activeTranslation
 */
class Page extends \intermundia\yiicms\models\Page
{

    public static function getTranslateModelClass()
    {
        return PageTranslation::class;
    }

    public function getFullPicture()
    {
        $images = $this->activeTranslation->image;
        $imgSources = [];
        foreach ($images as $image) {
            array_push($imgSources, $image->base_url . $image->path);
        }
        $extraSmallImg = '';
        $smallImg = '';
        $mediumImg = '';
        $largeImg = '';
        $extraSmallRetinaImg = '';
        $smallRetinaImg = '';
        $mediumRetinaImg = '';
        $largeRetinaImg = '';
        $mediaInnerText = "only screen and (-webkit-min-device-pixel-ratio: 2)," .
            "only screen and (   min--moz-device-pixel-ratio: 2)," .
            "only screen and (     -o-min-device-pixel-ratio: 2/1)," .
            "only screen and (        min-device-pixel-ratio: 2)," .
            "only screen and (                min-resolution: 192dpi)," .
            "only screen and (                min-resolution: 2dppx)";

        foreach ($imgSources as $url) {
            if (strpos($url, "-extra-small.")) {
                $extraSmallImg = $url;
            }
            if (strpos($url, "-small.")) {
                $smallImg = $url;
            }
            if (strpos($url, "-medium.")) {
                $mediumImg = $url;
            }
            if (strpos($url, "-large.")) {
                $largeImg = $url;
            }
            if (strpos($url, "-extra-small@2x.")) {
                $extraSmallRetinaImg = $url;
            }
            if (strpos($url, "-small@2x.")) {
                $smallRetinaImg = $url;
            }
            if (strpos($url, "-medium@2x.")) {
                $mediumRetinaImg = $url;
            }
            if (strpos($url, "-large@2x.")) {
                $largeRetinaImg = $url;
            }
        }
        return "<picture class='teaser-image'>" .

            "<source media='(max-width: 768px) and ${mediaInnerText}' srcset='${extraSmallRetinaImg}'/>" .
            "<source media='(max-width: 768px)' srcset='${extraSmallImg}'/>" .

            "<source media='(max-width: 992px) and ${mediaInnerText}' srcset='${smallRetinaImg}'/>" .
            "<source media='(max-width: 992px)' srcset='${smallImg}'/>" .

            "<source media='(max-width: 1200px) and ${mediaInnerText}' srcset='${mediumRetinaImg}'/>" .
            "<source media='(max-width: 1200px)' srcset='${mediumImg}'/>" .

            "<source media='${mediaInnerText}' srcset='${largeRetinaImg}'/>" .
            "<img alt='picture' src='${largeImg}'/>" .
            "</picture>";
    }
}
