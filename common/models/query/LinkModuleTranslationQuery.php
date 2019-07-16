<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\LinkModuleTranslation]].
 *
 * @see \common\models\LinkModuleTranslation
 */
class LinkModuleTranslationQuery extends BaseTranslationQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\LinkModuleTranslation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\LinkModuleTranslation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
