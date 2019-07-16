<?php

namespace common\models;

use Yii;

/**
 * @inheritdoc
 */
class VideoSection extends \intermundia\yiicms\models\VideoSection
{


    public static function getTranslateModelClass()
    {
        return VideoSectionTranslation::class;
    }
}
