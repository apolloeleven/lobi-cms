<?php

use common\models\User;
use common\rbac\Migration;

class m180723_122700_editor_role extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {

        $editor = $this->auth->createRole(User::ROLE_EDITOR);
        $this->auth->add($editor);

        $manager = $this->auth->getRole(User::ROLE_MANAGER);
        $this->auth->addChild($manager, $editor);
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->auth->remove($this->auth->getRole(User::ROLE_EDITOR));
    }
}
