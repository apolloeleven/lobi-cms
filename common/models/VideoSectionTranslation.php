<?php

namespace common\models;

use intermundia\yiicms\behaviors\FileManagerItemBehavior;
use intermundia\yiicms\models\Language;
use intermundia\yiicms\models\VideoSection;
use Yii;
use yii\web\UploadedFile;

/**
 * @inheritdoc
 *
 * @property
 */
class VideoSectionTranslation extends \intermundia\yiicms\models\VideoSectionTranslation
{
    /** @var UploadedFile */
    public $image = null;
    public $image_deleted = null;


    public function behaviors()
    {
        return array_merge([
            [
                'class' => FileManagerItemBehavior::class,
                'columnNames' => [
                    'image' => 'image'
                ],
            ]
        ], parent::behaviors());
    }

     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['video_section_id',], 'integer'],
            [['content_top', 'content_bottom'], 'string'],
            [['videoFile_deleted', 'mobileVideoFile_deleted'], 'safe'],
            [['language'], 'string', 'max' => 12],
            [['title'], 'string', 'max' => 255],
            [['videoFile'], 'file', 'maxFiles' => 20, 'skipOnEmpty' => true, 'extensions' => 'mp4, ogg, ogv, webm'],
            [['mobileVideoFile'], 'file', 'maxFiles' => 20, 'skipOnEmpty' => true, 'extensions' => 'mp4, ogg, ogv, webm'],
            ['image', 'file', 'maxFiles' => 20, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            [
                ['language'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Language::class,
                'targetAttribute' => ['language' => 'code']
            ],
            [
                ['video_section_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => VideoSection::class,
                'targetAttribute' => ['video_section_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'image' => Yii::t('common', 'Image'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoSection()
    {
        return $this->hasOne(VideoSection::class, ['id' => 'video_section_id']);
    }

    public function getModelClass()
    {
        return VideoSection::class;
    }
}
