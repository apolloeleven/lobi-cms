<?php

/**
 * @var $this  yii\web\View
 * @var $model apollo11\lobicms\models\Website
 */

use yii\helpers\Html;

?>

<?php echo \common\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'activeTranslation.title',
        'activeTranslation.short_description',
        'activeTranslation.logo_image_name',
        'activeTranslation.name',
        'activeTranslation.og_site_name',
        'activeTranslation.address_of_company',
        'activeTranslation.cookie_disclaimer_message',
        'activeTranslation.copyright',
        [
            'label' => 'Og Image',
            'format' => 'html',
            'value' => Html::img($model->activeTranslation->og_image->getUrl(), ['style' => 'width: 120px;'])
        ],
        [
            'label' => 'Logo Image',
            'format' => 'html',
            'value' => Html::img($model->activeTranslation->logo_image->getUrl(), ['style' => 'width: 120px;'])
        ],
        [
            'label' => 'Claim Image',
            'format' => 'html',
            'value' => Html::img($model->activeTranslation->claim_image->getUrl(), ['style' => 'width: 120px;'])
        ],
        'activeTranslation.google_tag_manager_code',
        'activeTranslation.html_code_before_close_body',
        'created_at:datetime', // creation date formatted as datetime
        'activeTranslation.address_of_company',
        'activeTranslation.footer_name',
        'activeTranslation.footer_headline',
        'activeTranslation.footer_plain_text',
        'activeTranslation.footer_copyright',
        'activeTranslation.footer_logo',
    ],
]);


?>



