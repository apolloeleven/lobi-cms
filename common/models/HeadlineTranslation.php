<?php

namespace common\models;

use intermundia\yiicms\behaviors\FileManagerItemBehavior;
use intermundia\yiicms\models\FileManagerItem;
use intermundia\yiicms\models\Language;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%headline_translation}}".
 *
 * @property int $id
 * @property int $headline_id
 * @property string $language
 * @property string $video_headline
 * @property string $text
 *
 * @property Language $language0
 * @property Headline $headline
 */
class HeadlineTranslation extends BaseTranslateModel
{

    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @var UploadedFile|FileManagerItem
     */
    public $videoFileMp4;
    public $videoFileOgv;
    public $videoFileWebm;

    public $deletedImages;

    public function behaviors()
    {
        return array_merge([
            [
                'class' => FileManagerItemBehavior::class,
                'tableName' => ContentTree::TABLE_NAME_HEADLINE,
                'columnNames' => [
                    'videoFileMp4' => 'videoFileMp4',
                    'videoFileOgv'=>'videoFileOgv',
                    'videoFileWebm'=>'videoFileWebm',
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
        return '{{%headline_translation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language'], 'required'],
            [['headline_id',], 'integer'],
            [['text'], 'string'],
            [['deletedImages'], 'safe'],
            ['videoFileMp4', 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4'],
            ['videoFileOgv', 'file', 'skipOnEmpty' => true, 'extensions' => 'ogv'],
            ['videoFileWebm', 'file', 'skipOnEmpty' => true, 'extensions' => 'webm'],
            [['language'], 'string', 'max' => 12],
            [['video_headline'], 'string', 'max' => 1024],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language' => 'code']],
            [['headline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Headline::class, 'targetAttribute' => ['headline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'headline_id' => Yii::t('common', 'Headline ID'),
            'language' => Yii::t('common', 'Language'),
            'video_headline' => Yii::t('common', 'Video Headline'),
            'text' => Yii::t('common', 'Text'),
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
    public function getHeadline()
    {
        return $this->hasOne(Headline::class, ['id' => 'headline_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\HeadlineTranslationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\HeadlineTranslationQuery(get_called_class());
    }

    public function getModelClass()
    {
        return Headline::class;
    }

    public function getForeignKeyNameOnModel()
    {
        return 'headline_id';
    }

    public function getTitle()
    {
        return $this->video_headline;
    }

    public function getShortDescription()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'id' => $this->id,
            'headline_id' => $this->headline_id,
            'language' => $this->language,
            'video_headline' => $this->video_headline,
            'text' => $this->text,
        ];
    }
}
