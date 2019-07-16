<?php

namespace common\models\query;

use common\models\Image;

/**
 * This is the ActiveQuery class for [[\common\models\Image]].
 *
 * @see \common\models\Image
 */
class ImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Image[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Image|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     * @return ImageQuery
     */
    public function byId($id)
    {
        return $this->andWhere([Image::tableName().'.id' => $id]);
    }
}
