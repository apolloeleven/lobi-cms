<?php
/**
 * User: zura
 * Date: 6/24/18
 * Time: 2:37 PM
 */

namespace backend\models;


/**
 * Class ContentTree
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package backend\models
 */
class ContentTree extends \intermundia\yiicms\models\ContentTree
{
    public function getParentsQuery()
    {
        return $this->parents();
    }

    public function getNodes()
    {
        return 'website/' . $this->getActualItemActiveTranslation()->alias_path;
    }
}
