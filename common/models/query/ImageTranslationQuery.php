<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ImageTranslation]].
 *
 * @see \common\models\ImageTranslation
 */
class ImageTranslationQuery extends BaseTranslationQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ImageTranslation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ImageTranslation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
