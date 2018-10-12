<?php

use yii\db\Migration;

/**
 * Class m181010_160525_create_table_widget_text_translation
 */
class m181010_160525_create_table_widget_text_translation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%widget_text_translation}}', [
            'id' => $this->primaryKey(11),
            'widget_text_id' => $this->integer(11)->notNull(),
            'locale' => $this->string(15)->notNull(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull()
        ]);

        $this->addForeignKey('{{%FK_widget_text_translation_widget_text}}',
            '{{%widget_text_translation}}',
            'widget_text_id',
            '{{%widget_text}}',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%FK_widget_text_translation_widget_text}}','{{%widget_text_translation}}');
        $this->dropTable('{{%widget_text_translation}}');
    }

}
