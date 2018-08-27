<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model apollo11\lobicms\models\TimelineEvent
 */
?>
<div class="timeline-badge bg-cyan"><i class="fa <?php echo $model->getIcon() ?>"></i></div>
<div class="timeline-panel">
    <div class="timeline-heading">
        <h5 class="timeline-title"><b><?php echo $model->getDisplayText() ?></b></h5>
        <small class="text-muted"><?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?></small>
    </div>
<!--    <div class="timeline-body">-->
<!--        <div class="media">-->
<!--            <div class="media-left">-->
<!--                <a href="#">-->
<!--                    <img class="media-object" src="img/demo/100x100-6.jpg" width="50" alt="...">-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="media-body">-->
<!--                <h5 class="media-heading">--><?php //echo $model->record_name ?><!--</h5>-->
<!--                <small class="text-muted">03:15</small>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>