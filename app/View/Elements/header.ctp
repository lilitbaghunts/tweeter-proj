<div class="navbar navbar-inverse navbar-fixed-top">

    <div class="navbar-inner">
        <div class="container-fluid">
            <ul class="nav">

                <?php if(!$u_id && !is_numeric($u_id)){ ?>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'main'), true); ?>">Main</a></li>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'register'), true); ?>">Sign up</a></li>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'login'), true); ?>">Login</a><li>
                    <?php }else{ ?>

                    <li><a class ="active" href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'home'), true); ?>">Home</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'myProfile'), true); ?>">Me<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'editProfile'), true); ?>">Edit profile</a></li>
                            <li><a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'addTweet'), true); ?>">Add tweet</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'followers')); ?>">Followers</a>
                    <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'following')); ?>">Following</a>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout'), true); ?>">Logout</a><li>

                    <?php } ?>

            </ul>
        </div>
    </div>
</div>

<?php echo $this->Html->script('twitter_bootsrap_dropdown'); ?>


<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">

            <ul class="nav navbar-nav">
                <?php if(!$u_id && !is_numeric($u_id)){ ?>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'main'), true); ?>">Main</a></li>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'register'), true); ?>">Sign up</a></li>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'login'), true); ?>">Login</a><li>
                    <?php }else{ ?>

                    <li><a class="active" href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'home'), true); ?>">Home</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href ="#">Me<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'myProfile'), true); ?>">View profile</a></li>
                            <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'editProfile'), true); ?>">Edit profile</a></li>
                            <li><a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'addTweet'), true); ?>">Add tweet</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'followers')); ?>">Followers</a>
                    <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'following')); ?>">Following</a>
                    <li><a href ="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout'), true); ?>">Logout</a><li>

                    <?php } ?>

            </ul>

        </div><!--/.nav-collapse -->
    </div>
</div>

