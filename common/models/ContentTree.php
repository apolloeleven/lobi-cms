<?php
/**
 * User: zura
 * Date: 6/24/18
 * Time: 2:37 PM
 */

namespace common\models;


/**
 * Class ContentTree
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package backend\models
 */
class ContentTree extends \intermundia\yiicms\models\ContentTree
{

    public function getItemsQuery(
        $tableNames = [
            parent::TABLE_NAME_VIDEO_SECTION,
            parent::TABLE_NAME_SECTION,
            parent::TABLE_NAME_CONTENT_TEXT,
            parent::TABLE_NAME_CAROUSEL,
            parent::TABLE_NAME_CAROUSEL_ITEM,
        ]
    ) {
        return $this->children(1)
            ->with([
                'currentTranslation',
                'defaultTranslation',
                'link.currentTranslation',
                'link.defaultTranslation'
            ])
            ->andWhere(['table_name' => $tableNames])
            ->notDeleted();
    }
}
