<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model intermundia\yiicms\models\TimelineEvent
 */
?>
<div class="timeline-badge bg-success"><i class="fa fa-user"></i></div>
<div class="timeline-panel">
    <div class="timeline-heading">
        <h5 class="timeline-title">
            <b>
                <?php echo Yii::t('backend', 'New user ({identity}) was registered at {created_at}', [
                    'identity' => \yii\helpers\Html::a(
                        $model->data['public_identity'],
                        ['/user/view', 'id' => $model->data['user_id']],
                        ['class' => 'text-danger']
                    ),
                    'created_at' => Yii::$app->formatter->asDatetime($model->data['created_at'])
                ]) ?>
            </b>
        </h5>
        <small class="text-muted"><?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        <?php echo $model->createdBy ? Yii::t('backend', 'By') . ' ' . $model->createdBy->username : ''; ?></small>
    </div>
</div>