<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 7/25/18
 * Time: 6:53 PM
 * @author Saiat Kalbiev <kalbievich11@gmail.com>
 */

namespace common\widgets;


use yii\bootstrap\Html;

class Carousel extends \yii\bootstrap\Carousel
{
    public $controls = ['<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'];

    public function renderIndicators()
    {
        if ($this->showIndicators === false) {
            return '';
        }
        $indicators = [];
        foreach ($this->items as $i => $item) {
            $options = ['data-target' => '#' . $this->options['id'], 'data-slide-to' => $i];
            if ($i === 0) {
                Html::addCssClass($options, 'active');
            }
            $indicators[] = Html::tag('li', $item['content'], $options);
        }

        return Html::tag('ol', implode("\n", $indicators), ['class' => 'carousel-indicators']);
    }
}