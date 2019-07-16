<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 6/20/18
 * Time: 7:19 PM
 */

namespace backend\widgets;


use intermundia\yiicms\models\Language;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class LanguageSelector extends InputWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->getView()->registerJs("$('#$this->id').change(function (ev) {
            var drop = $(this);
            var option = drop.find('[value=\"'+this.value+'\"]');
            window.location.href = option.attr('data-url');  
        });");

        $languages = Language::find()->all();
        if ($this->hasModel()) {

            return Html::activedropDownList($this->model, $this->attribute,
                ArrayHelper::map($languages, 'code', 'name'), [
                    'id' => $this->id,
                    'class' => 'form-control',
                    'options' => ArrayHelper::map($languages, 'code', function ($language) {
                        $params = array_merge([''], Yii::$app->request->get(), ['language' => $language->code]);
                        return [
                            'data-url' => Url::to($params),
                        ];
                    })
                ]) ;
        }

    }

}
