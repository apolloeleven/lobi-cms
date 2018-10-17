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
            'format' => 'html',
            'value' => Html::a($model->getAttrForFile('videoFile', 'name'), $model->getUrlForFile('videoFile')),
        ],
        [
            'label' => Yii::t('backend', 'Mobile Video File'),
            'format' => 'html',
            'value' => Html::a($model->getAttrForFile('mobileVideoFile', 'name'),
                $model->getUrlForFile('mobileVideoFile')),
        ]
    ]
]);

?>
