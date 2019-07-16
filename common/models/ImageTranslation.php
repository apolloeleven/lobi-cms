<?php

namespace common\models;

use intermundia\yiicms\behaviors\FileManagerItemBehavior;
use intermundia\yiicms\models\FileManagerItem;
use intermundia\yiicms\models\Language;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%image_translation}}".
 *
 * @property int $id
 * @property int $image_id
 * @property string $language
 * @property string $name
 * @property string $alt_text
 *
 * @property Language $language0
 * @property Image $image
 */
class ImageTranslation extends BaseTranslateModel
{

    /**
     * @author Lasha Lomidze <lashaa.lomidze@gmail.com>
     * @var UploadedFile|FileManagerItem
     */
    public $imageExtraSmall;
    public $imageExtraSmallDouble;
    public $imageSmall;
    public $imageSmallDouble;
    public $imageMedium;
    public $imageMediumDouble;
    public $imageLarge;
    public $imageLargeDouble;
    public $deletedImages;

    public function behaviors()
    {
        return array_merge([
            [
                'class' => FileManagerItemBehavior::class,
                'tableName' => ContentTree::TABLE_NAME_IMAGE,
                'columnNames' => [
                    'imageExtraSmall' => 'imageExtraSmall',
                    'imageExtraSmallDouble'=>'imageExtraSmallDouble',
                    'imageSmall'=>'imageSmall',
                    'imageSmallDouble'=>'imageSmallDouble',
                    'imageMedium'=>'imageMedium',
                    'imageMediumDouble'=>'imageMediumDouble',
                    'imageLarge'=>'imageLarge',
                    'imageLargeDouble'=>'imageLargeDouble',
                ],
                'deletedImages' => 'deletedImages',
                'recordIdAttribute' => $this->getForeignKeyNameOnModel(),
                'filePath' => '[[attribute_language]]/[[attribute_alias_path]]/[[column]]_[[filename]].[[extension]]'
            ]
        ], parent::behaviors());
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image_translation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alt_text'], 'string'],
            [['language'], 'required'],
            [['image_id',], 'integer'],
            [['deletedImages'], 'safe'],
            ['imageExtraSmall', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageExtraSmallDouble', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageSmall', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageSmallDouble', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageMedium', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageMediumDouble', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageLarge', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            ['imageLargeDouble', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            [['language'], 'string', 'max' => 12],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language' => 'code']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'image_id' => Yii::t('common', 'Image ID'),
            'language' => Yii::t('common', 'Language'),
            'name' => Yii::t('common', 'Name'),
            'alt_text' => Yii::t('common', 'Alt-Text')
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
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }


    /**
     * {@inheritdoc}
     * @return \common\models\query\ImageTranslationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ImageTranslationQuery(get_called_class());
    }

    public function getModelClass()
    {
        return Image::class;
    }

    public function getForeignKeyNameOnModel()
    {
        return 'image_id';
    }

    public function getTitle()
    {
        return $this->name;
    }

    public function getShortDescription()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'id' => $this->id,
            'image_id' => $this->image_id,
            'language' => $this->language,
            'name' => $this->name,
            'alt_text' => $this->alt_text
        ];
    }
}
