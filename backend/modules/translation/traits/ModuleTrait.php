<?php

namespace backend\modules\translation\traits;


use Yii;

trait ModuleTrait
{

    /**
     * @return array
     */
    public function getLanguages()
    {
        $languages = [];
        foreach (Yii::$app->websiteLanguages as $locale => $name) {
            if ($locale !== Yii::$app->sourceLanguage)
                $languages[str_replace('-', '_', $locale)] = $name;
        }

        return $languages;
    }

}