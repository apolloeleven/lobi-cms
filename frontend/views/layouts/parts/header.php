<?php use yii\bootstrap\ButtonDropdown;

if (Yii::$app->user->canEditContent()): ?>
    <div class="alert alert-warning content-editor">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <span><?php echo Yii::t('frontend', 'You are in the Content Editing mode') ?></span>
                </div>
                <div class="col-md-3 text-right">
                    <label><input id="with-hidden-checkbox"
                            <?php echo !Yii::$app->request->get('hidden') ?: 'checked' ?>
                                  type="checkbox" name="with-hidden"> With Hidden</label>
                </div>
                <div class="col-md-1 text-right">
                    <?php echo \yii\helpers\Html::a(Yii::t('frontend', 'Logout'),
                        \yii\helpers\Url::to(['/user/sign-in/logout']),
                        ['data-method' => 'post', 'class' => 'btn btn-sm btn-danger']) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img height="20" src="img/logo.png">
                </a>
                <a class="navbar-brand" href="#">
                    Lobi CMS
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php echo \apollo11\lobicms\widgets\NestedMenu::widget() ?>
<!--                <form class="navbar-form navbar-left">-->
<!--                    <div class="form-group">-->
<!--                        <input type="text" class="form-control" placeholder="Search">-->
<!--                    </div>-->
<!--                    <button type="submit" class="btn btn-default">Submit</button>-->
<!--                </form>-->
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
