<?php

use yii\db\Migration;

/**
 * Handles adding subheadline to table `teaser_translation`.
 */
class m181212_181400_add_alt_text_column_to_content_text_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%content_text_translation}}', 'alt_text', $this->string(1024));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%content_text_translation}}','alt_text');
    }
}
