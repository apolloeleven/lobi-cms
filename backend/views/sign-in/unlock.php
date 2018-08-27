<?php
/**
 * User: zura
 * Date: 6/25/18
 * Time: 1:39 PM
 */

use yii\widgets\ActiveForm;

/** @var $this \yii\web\View */
/** @var $lockedUser array */
/** @var $model \backend\models\LoginForm */

$this->registerCssFile('/css/animate.css');
$this->registerCssFile('/css/lock-screen.css');
$this->registerJs('
    $(function(){
        var CONFIG = window.LobiAdminConfig;
        //Initialize time on lock screen and timeout for show slideshow
        (function () {
            var monthNames = CONFIG.monthNames;
            var weekNames = CONFIG.weekNames;
            setInterval(function () {
                var d = new Date();
                var h = d.getHours();
                var m = d.getMinutes();
                $(\'.lock-screen-time\').html((Math.floor(h / 10) === 0 ? "0" : "") + h + ":" + (Math.floor(m / 10) === 0 ? "0" : "") + m);
                $(\'.lock-screen-date\').html(weekNames[d.getDay()] + ", " + monthNames[d.getMonth()] + " " + d.getDate());
            }, CONFIG.updateTimeForLockScreen);

        })();
        //Initialize carousel and catch form submit
        (function () {
            var $lock = $(\'.lock-screen\');
            var $car = $lock.find(\'.carousel\');
            var $items = $car.find(\'.item\');
            $items.removeClass(\'active\').eq(Math.floor(Math.random() * $items.length)).addClass(\'active\');
            $car.click(function () {
                $car.parent().addClass(\'slideOutUp\').removeClass(\'slideInDown\');
                setTimeout(function () {
                    $(\'.lock-screen .carousel-wrapper\').removeClass(\'slideOutUp\').addClass(\'slideInDown\');
                }, CONFIG.showLockScreenTimeout);
            });
            $car.carousel({
                pause: false,
                interval: 8000
            });
        })();
    });
')
?>

<div class="lock-screen slideInDown animated">
    <div class="lock-form-wrapper">
        <div>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'options' => [
                    'class' => 'lock-screen-form lobi-form'
                ],
                'fieldConfig' => [
                    'template' => '<div class="input-group">{input}
                                        <span class="input-group-btn">
                                            <button class="btn btn-info"><i class="fa fa-key"></i></button>
                                        </span>
                                    </div>
                                    <div class="text-danger">{error}</div>',
                    'options' => [
                        'tag' => false
                    ]
                ]
            ]); ?>
            <div class="row lock-screen-body">
                <div class="col-xxs-12 col-xs-4">
                    <img src="<?php echo $lockedUser['avatar'] ?>" class="horizontal-center img-responsive" alt/>
                </div>
                <div class="col-xxs-12 col-xs-8">
                    <h4 class="fullname"><?php echo $lockedUser['fullname'] ?>
                        <small class="text-gray pull-right"><i class="fa fa-lock"></i> <?php echo Yii::t('backend',
                                'Locked') ?></small>
                    </h4>
                    <h6 class="lock-screen-email"><?php echo $lockedUser['email'] ?></h6>
                    <div class="form-group margin-bottom-5 <?php echo $model->hasErrors() ? 'has-error' : '' ?>">
                        <?php echo $form->field($model, 'username', [
                            'template' => '{input}'
                        ])->hiddenInput() ?>

                        <?php echo $form->field($model, 'password', [
                            'inputOptions' => [
                                'placeholder' => Yii::t('backend', 'Type password to unlock')
                            ]
                        ])->passwordInput() ?>
                        <!--                            <input type="password" class="form-control" placeholder="Type password to unlock">-->

                    </div>
                </div>
                <span class="text-gray-lighter">Login as someone else? <a
                            href="<?php echo \yii\helpers\Url::to(['/sign-in/login']) ?>">Click here</a></span>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="carousel-wrapper slideInDown animated">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="fill" style="background-image:url('/img/demo/9_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('/img/demo/8_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('/img/demo/5_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('/img/demo/2_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('/img/demo/3_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('/img/demo/5_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('/img/demo/6_1920.jpg');">
                        <div class="container">

                        </div>
                    </div>
                </div>
            </div>
            <div class="lock-screen-clock">
                <div class="lock-screen-time"></div>
                <div class="lock-screen-date"></div>
            </div>
        </div>
    </div>
</div>
