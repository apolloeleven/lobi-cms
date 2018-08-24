<?php
/**
 * User: zura
 * Date: 6/22/18
 * Time: 8:20 PM
 */

namespace common\widgets;


/**
 * Class DetailView
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package common\widgets
 */
class DetailView extends \yii\widgets\DetailView
{
    public $template = '<dl><dt{captionOptions}>{label}</dt><dd{contentOptions}>{value}</dd></dl><hr>';
}