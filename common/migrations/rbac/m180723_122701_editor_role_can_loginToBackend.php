<?php

use common\models\User;
use common\rbac\Migration;

class m180723_122701_editor_role_can_loginToBackend extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {

        $loginToBackend = $this->auth->getPermission('loginToBackend');
        $editor = $this->auth->getRole(User::ROLE_EDITOR);

        $this->auth->addChild($editor, $loginToBackend);
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $loginToBackend = $this->auth->getPermission('loginToBackend');
        $editor = $this->auth->getRole(User::ROLE_EDITOR);

        $this->auth->removeChild($editor, $loginToBackend);
    }
}
