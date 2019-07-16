<?php
/**
 * Created by PhpStorm.
 * User: guga
 * Date: 12/19/18
 * Time: 3:47 PM
 */
/** @var \frontend\models\ContactForm $model */
$form = \yii\bootstrap\ActiveForm::begin();

?>

<html>
<body>
<?php foreach ($model->attributeLabels() as $attr => $label): ?>
    <p><strong><?php echo $label ?>:</strong> <?php echo $model->$attr; ?></p>
<?php endforeach; ?>

<?php echo \intermundia\yiicms\widgets\DbText::widget([
    'key' => 'contact-form-checkbox-text'
]) ?>

<hr>
<br>
<?php echo \intermundia\yiicms\widgets\DbText::widget([
    'key' => 'contact-form-email-note'
]) ?>
</body>
</html>
