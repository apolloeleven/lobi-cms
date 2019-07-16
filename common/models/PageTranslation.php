<?php

namespace common\models;

/**
 * This is the model class for table "page_translation".
 *
 * @property int $id
 * @property int $page_id
 * @property string $language
 * @property string $title
 * @property string $body
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Page $page
 */
class PageTranslation extends \intermundia\yiicms\models\PageTranslation
{

}
