<?php

namespace common\commands;

use apollo11\lobicms\models\TimelineEvent;
use trntv\bus\interfaces\SelfHandlingCommand;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Json;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class AddToTimelineCommand extends BaseObject implements SelfHandlingCommand
{
    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $event;

    /**
     * @var
     */
    public $record_id;

    /**
     * @var
     */
    public $record_name;

    /**
     * @var mixed
     */
    public $data;

    public $createdBy;

    /**
     * @param AddToTimelineCommand $command
     * @return bool
     */
    public function handle($command)
    {
        $model = new TimelineEvent();
        $model->application = Yii::$app->id;
        $model->group = $this->group;
        $model->category = $command->category;
        $model->event = $command->event;
        $model->record_id = $command->record_id;
        $model->record_name = $command->record_name;
        $model->created_by = $command->createdBy;
        $model->data = Json::encode($command->data);
        return $model->save(false);
    }
}
