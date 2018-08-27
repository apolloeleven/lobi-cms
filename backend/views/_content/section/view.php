<?php

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\query\CountryTranslationQuery
 */

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model->activeTranslation,
    'attributes' => [
        'title',
        [
            'label' => $model->activeTranslation->attributeLabels()['template'],
            'format' => 'html',
            'value' => '<div class="highlight">
            <pre><code class="html">'.$model->activeTranslation->getEncodedTemplate().'</code>
            </pre>
        </div>'
        ],
        'description:html',
    ],
]);

?>
