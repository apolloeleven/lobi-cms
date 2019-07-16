<?php

namespace common\models;

use intermundia\yiicms\models\Language;
use Yii;

/**
 * This is the model class for table "{{%content_text_translation}}".
 *
 * @property int $id
 * @property int $content_text_id
 * @property string $language
 * @property string $name
 * @property string $single_line
 * @property string $multi_line
 * @property string $alt_text
 *
 * @property ContentText $contentText
 * @property Language $language0
 */
class ContentTextTranslation extends \intermundia\yiicms\models\ContentTextTranslation
{


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_text_id'], 'integer'],
            [['multi_line', 'multi_line2'], 'string'],
            [['image_deleted'], 'safe'],
            [['language'], 'string', 'max' => 12],
            [['alt_text', 'name'], 'string', 'max' => 1024],
            ['image', 'file', 'maxFiles' => 20, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            [['single_line'], 'string', 'max' => 2048],
            [['content_text_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContentText::class, 'targetAttribute' => ['content_text_id' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language' => 'code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'alt_text' => Yii::t('common', 'Alt Text'),
        ]);
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return ContentText::class;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentText()
    {
        return $this->hasOne(ContentText::class, ['id' => 'content_text_id']);
    }
}
