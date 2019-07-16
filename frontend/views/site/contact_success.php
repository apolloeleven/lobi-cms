<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

?>
<?php Pjax::begin([
    'enablePushState' => false
]); ?>
<h3><?php echo Yii::t('frontend', 'Thanks for your message') ?></h3>

<?php Pjax::end(); ?>