<?php

namespace common\models;


class Website extends \intermundia\yiicms\models\Website
{
    public static function getTranslateModelClass()
    {
        return WebsiteTranslation::class;
    }

}
