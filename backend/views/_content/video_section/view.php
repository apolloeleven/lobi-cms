<?php

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\VideoSectionTranslation
 */

use yii\helpers\Html;
use yii\helpers\Url;


?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model->activeTranslation,
    'attributes' => [
        'title',
        'content_top:html',
        'content_bottom:html',
        [                      // the owner name of the model
            'label' => Yii::t('backend', 'Video File'),
            'format'=> 'html',
            'value' => function ($data) {
                if ($data->fileManagerVideoFile) {
                    return Html::a($data->fileManagerVideoFile->name, $data->fileManagerVideoFile->getUrl());
                }
                return '';
            }
        ],
    ],
]);

?>
