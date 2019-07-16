<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%link_module}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $deleted_at
 * @property int $deleted_by
 *
 * @property User $deletedBy
 * @property LinkModuleTranslation[] $linkModuleTranslations
 * @property LinkModuleTranslation $activeTranslation
 * @property LinkModuleTranslation $translation
 */
class LinkModule extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%link_module}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deleted_at', 'deleted_by', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['deleted_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'deleted_at' => Yii::t('common', 'Deleted At'),
            'deleted_by' => Yii::t('common', 'Deleted By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkModuleTranslations()
    {
        return $this->hasMany(LinkModuleTranslation::class, ['link_module_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\LinkModuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LinkModuleQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveTranslation()
    {
        return $this->hasOne(LinkModuleTranslation::class, ['link_module_id' => 'id'])->andWhere(['language' => Yii::$app->language]);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->activeTranslation->title;
    }

    public static function getTranslateModelClass()
    {
        return LinkModuleTranslation::class;
    }

    public static function getTranslateForeignKeyName()
    {
        return 'link_module_id';
    }
}
