<?php
/**
 * User: zura
 * Date: 6/23/18
 * Time: 6:32 PM
 */

namespace common\components;

use yii\base\Component;


/**
 * Class CKEditorComponent
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package common\components
 */
class CKEditorComponent extends Component
{
    /**
     * Array of Ck Editor Styles. Each item must have `name`: string, `element`: "tag of html element" and `attributes`: associative array
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @var array
     */
    public $customStyles = [];
}