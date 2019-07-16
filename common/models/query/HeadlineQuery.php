<?php

namespace common\models\query;

use common\models\Headline;

/**
 * This is the ActiveQuery class for [[\common\models\Headline]].
 *
 * @see \common\models\Headline
 */
class HeadlineQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Headline[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Headline|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     * @return HeadlineQuery
     */
    public function byId($id)
    {
        return $this->andWhere([Headline::tableName().'.id' => $id]);
    }
}
