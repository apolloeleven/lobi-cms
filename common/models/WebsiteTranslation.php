<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "website_translation".
 *
 * @property string $admin_email
 * @property string $bcc_email
 * @property string $cc_email
 *
 * @property Website $website
 */
class WebsiteTranslation extends \intermundia\yiicms\models\WebsiteTranslation
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['admin_email', 'cc_email', 'bcc_email'], 'email'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'admin_email' => Yii::t('common', 'Admin Email'),
            'bcc_email' => Yii::t('common', 'BCC Email'),
            'cc_email' => Yii::t('common', 'CC Email')

        ]);
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Website::class;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::class, ['id' => 'content_text_id']);
    }
}
