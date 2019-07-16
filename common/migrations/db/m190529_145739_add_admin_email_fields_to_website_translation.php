<?php

use yii\db\Migration;

/**
 * Class m190529_145739_add_admin_email_fields_to_website_translation
 */
class m190529_145739_add_admin_email_fields_to_website_translation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%website_translation}}', 'admin_email', $this->text());
        $this->addColumn('{{%website_translation}}', 'cc_email', $this->text());
        $this->addColumn('{{%website_translation}}', 'bcc_email', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%website_translation}}', 'admin_email');
        $this->dropColumn('{{%website_translation}}', 'cc_email');
        $this->dropColumn('{{%website_translation}}', 'bcc_email');
    }
}
