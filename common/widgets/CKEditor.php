<?php
/**
 * User: zura
 * Date: 6/23/18
 * Time: 6:27 PM
 */

namespace common\widgets;

use yii\helpers\Json;


/**
 * Class CKEditor
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package common\widgets
 */
class CKEditor extends \dosamigos\ckeditor\CKEditor
{
    public $clientOptions = ['format_tags' => 'p;h1;h2;h3;h4;h5;h6;pre;address;div'];
}
