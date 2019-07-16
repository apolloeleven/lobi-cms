<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%content_text}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $deleted_at
 * @property int $deleted_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 *
 * @property ContentTextTranslation[] $contentTextTranslations
 * @property ContentTextTranslation[] $translations
 * @property ContentTextTranslation $activeTranslation
 */
class ContentText extends \intermundia\yiicms\models\ContentText
{

    public static function getTranslateModelClass()
    {
        return ContentTextTranslation::class;
    }

}