<?php

namespace common\models\query;

use common\models\LinkModule;

/**
 * This is the ActiveQuery class for [[\common\models\LinkModule]].
 *
 * @see \common\models\LinkModule
 */
class LinkModuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\LinkModule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\LinkModule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     * @return LinkModuleQuery
     */
    public function byId($id)
    {
        return $this->andWhere([LinkModule::tableName().'.id' => $id]);
    }
}
