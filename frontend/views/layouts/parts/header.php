<?php

echo \apollo11\lobicms\widgets\ContentEditingToolbar::widget();

?>
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
