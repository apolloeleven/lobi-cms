<?php
/**
 * User: zura
 * Date: 12/7/18
 * Time: 7:28 PM
 */

namespace console\controllers;


use common\models\BaseModel;
use yii\console\Controller;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\VarDumper;

/**
 * Class DbController
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package console\controllers
 */
class DbController extends Controller
{
    public function actionUpdateTrademark()
    {
        $user = \common\models\User::findByUsername('webmaster');
        \Yii::$app->user->setIdentity($user);

        $trademarkDetectRegex = '/([a-z0-9])(®|&reg;)/';

        foreach (\Yii::$app->contentTree->editableContent as $item) {
            /** @var BaseModel $baseModel */
            $translationClass = $item['class'] . "Translation";
            /** @var ActiveQuery $query */

            $query = $translationClass::find();
            $items = $query
//                    ->where("$searchableAttribute REGEXP '[a-z0-9]® ' OR $searchableAttribute REGEXP '[a-z0-9]&reg; '")
                ->all();
            $this->log("Selected " . count($items) . " records from \"$translationClass\"");
            $this->log("_________________________________________________________________");

            $counterByAttr = [];
            foreach (ArrayHelper::getValue($item, 'searchableAttributes', []) as $searchableAttribute) {

                $counterByAttr[$searchableAttribute] = 0;

                foreach ($items as $item) {
                    preg_match($trademarkDetectRegex, $item->$searchableAttribute, $matches);
                    if ($matches) {
                        $this->log($item->$searchableAttribute);
                        $item->$searchableAttribute = preg_replace($trademarkDetectRegex, '$1<sup>$2</sup>',
                            $item->$searchableAttribute);
                        $this->log($item->$searchableAttribute);
                        if ($item->save()){
                            $counterByAttr[$searchableAttribute]++;
                        } else {
                            \Yii::error("[ERROR] - Unable to update \"$translationClass\". ID: $item->id. ERRORS: ".VarDumper::dumpAsString($item->errors));
                        }
                    }
                }

//                echo '<pre>';
//                var_dump(ArrayHelper::toArray($items));
//                echo '</pre>';
//                exit;
            }

            foreach ($counterByAttr as $attr => $counter) {
                if ($counter) {
                    $this->log("$counter records were updated for \"$attr\" in \"$translationClass\"");
                }
            }
            $this->log("");
            $this->log("=================================================================");
            $this->log("=================================================================");
            $this->log("");
        }
    }

    private function log($message)
    {
        Console::output("[ " . \Yii::$app->formatter->asDatetime(time()) . " ] - " . $message);
    }
}