<?php

namespace common\models;

use intermundia\yiicms\behaviors\FileManagerItemBehavior;
use intermundia\yiicms\models\FileManagerItem;
use intermundia\yiicms\models\Language;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%link_module_translation}}".
 *
 * @property int $id
 * @property int $link_module_id
 * @property string $language
 * @property string $title
 *
 * @property Language $language0
 * @property LinkModule $link_module
 */
class LinkModuleTranslation extends BaseTranslateModel
{

    public function behaviors()
    {

        return parent::behaviors();

    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%link_module_translation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language'], 'required'],
            [['link_module_id',], 'integer'],
            [['title'], 'string'],
            [['language'], 'string', 'max' => 12],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language' => 'code']],
            [['link_module_id'], 'exist', 'skipOnError' => true, 'targetClass' => LinkModule::class, 'targetAttribute' => ['link_module_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'link_module_id' => Yii::t('common', 'Link Module ID'),
            'language' => Yii::t('common', 'Language'),
            'title' => Yii::t('common', 'Title'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(Language::class, ['code' => 'language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkModule()
    {
        return $this->hasOne(LinkModule::class, ['id' => 'link_module_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\LinkModuleTranslationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LinkModuleTranslationQuery(get_called_class());
    }

    public function getModelClass()
    {
        return LinkModule::class;
    }

    public function getForeignKeyNameOnModel()
    {
        return 'link_module_id';
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getShortDescription()
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'id' => $this->id,
            'link_module_id' => $this->link_module_id,
            'language' => $this->language,
            'title' => $this->title,
        ];
    }
}
