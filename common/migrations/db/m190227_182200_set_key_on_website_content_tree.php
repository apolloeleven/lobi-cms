<?php

use yii\db\Migration;

/**
 * Handles adding subheadline to table `teaser_translation`.
 */
class m190227_182200_set_key_on_website_content_tree extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $websiteContentTree = \common\models\ContentTree::findClean()->andWhere([
            'table_name' => \common\models\ContentTree::TABLE_NAME_WEBSITE
        ])->one();
        $websiteContentTree->key = 'lobi-cms.en';
        $websiteContentTree->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $websiteContentTree = \common\models\ContentTree::findClean()->andWhere([
            'table_name' => \common\models\ContentTree::TABLE_NAME_WEBSITE
        ])->one();
        $websiteContentTree->key = null;
        $websiteContentTree->save();
    }
}
