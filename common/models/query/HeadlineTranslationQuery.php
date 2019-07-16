<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\HeadlineTranslation]].
 *
 * @see \common\models\HeadlineTranslation
 */
class HeadlineTranslationQuery extends BaseTranslationQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\HeadlineTranslation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\HeadlineTranslation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
