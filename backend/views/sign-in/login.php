<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

$this->registerCssFile('/css/login.css');

$this->title = Yii::t('backend', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
$this->params['body-class'] = 'login-page';
?>
<div class="login-wrapper fadeInDown animated">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'lobi-form login-form visible'
        ],
        'fieldConfig' => [
            'template' => '{input}',
            'options' => [
                'tag' => false
            ]
        ]
    ]); ?>
        <div class="login-header">
            Login to your account
        </div>
        <div class="login-body no-padding">
            <fieldset>





                <div class="form-group">
                    <label>Username</label>
                    <label class="input">
                        <span class="input-icon input-icon-prepend fa fa-user"></span>
<!--                        <input type="text" name="username" placeholder="Username">-->
                        <?php echo $form->field($model, 'username') ?>
                        <span class="tooltip tooltip-top-left"><i class="fa fa-user text-cyan-dark"></i> Please enter the username</span>
                    </label>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <label class="input">
                        <span class="input-icon input-icon-prepend fa fa-key"></span>
<!--                        <input type="password" name="password" placeholder="Password">-->
                        <?php echo $form->field($model, 'password')->passwordInput() ?>
                        <span class="tooltip tooltip-top-left"><i class="fa fa-key text-cyan-dark"></i> Please enter your password</span>
                    </label>
<!--                    <button type="button" class="btn-link btn-forgot-password">Forgot your password?</button>-->
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <label class="checkbox lobicheck lobicheck-info lobicheck-inversed lobicheck-lg">
                            <?php echo $form->field($model, 'rememberMe')->checkbox(['class' => 'simple']) ?>
                            <i></i>
                        </label>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-info btn-block"><span
                                    class="glyphicon glyphicon-log-in"></span> Login
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>
    <?php ActiveForm::end() ?>
</div>

<!---->
<!--<div class="login-box">-->
<!--    <div class="login-logo">-->
<!--        --><?php //echo Html::encode($this->title) ?>
<!--    </div><!-- /.login-logo -->-->
<!--    <div class="header"></div>-->
<!--    <div class="login-box-body">-->
<!--        --><?php //$form = ActiveForm::begin(['id' => 'login-form']); ?>
<!--        <div class="body">-->
<!--            --><?php //echo $form->field($model, 'username') ?>
<!--            --><?php //echo $form->field($model, 'password')->passwordInput() ?>
<!--            --><?php //echo $form->field($model, 'rememberMe')->checkbox(['class' => 'simple']) ?>
<!--        </div>-->
<!--        <div class="footer">-->
<!--            --><?php //echo Html::submitButton(Yii::t('backend', 'Sign me in'), [
//                'class' => 'btn btn-primary btn-flat btn-block',
//                'name' => 'login-button'
//            ]) ?>
<!--        </div>-->
<!--        --><?php //ActiveForm::end() ?>
<!--    </div>-->
<!---->
<!--</div>-->
