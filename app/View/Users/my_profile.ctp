<div class="hero-unit">
    <div class="container">
        <div class="well">
            <?php if(!empty($currentUser)){ ?>  


                <p><i class="icon-user"> </i><?php echo ' ' . $currentUser['User']['first_name'] . ' ' . $currentUser['User']['last_name']; ?></p>
                <?php
                if(!empty($currentUser['User']['image'])){
                    if(file_exists(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $currentUser['User']['image'])){
                        $img = '/system/thumbs/' . $currentUser['User']['image'];
                    }else{
                        $img = '/img/default.jpg';
                    }
                }else{
                    $img = '/img/default.jpg';
                }
                ?>
                <p><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'uploadPhoto'), true); ?>"><?php echo $this->Html->image($img, array('class' => "img-rounded")); ?></a></p>
                <div><label class="badge">Username</label>
                    <?php echo $currentUser['User']['username']; ?>
                </div>
                <div>
                    <label class="badge">Email</label>
                    <?php echo $currentUser['User']['email']; ?>
                </div>
                <div>
                    <label class="badge">Birthdate</label>

                    <?php echo date('m/d/Y', strtotime($currentUser['User']['birthdate'])); ?>
                </div>
                <div>
                    <label class="badge">Summary</label>
                    <?php echo $currentUser['User']['summary']; ?>
                </div>




            <?php } ?>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'uploadPhoto'), true); ?>" class="btn btn-default">Change photo</a>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'editProfile'), true); ?>" class="btn btn-default">Edit profile <i class="icon-edit"></i></a>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'changePassword'), true); ?>" class="btn btn-default">Change password</a>
            <a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'addTweet'), true); ?>" class="btn btn-default">Add Tweet</a>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'followers')); ?>"class="btn btn-mini">Followers</a>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'following')); ?>"class="btn btn-mini">Following</a>
        </div>

        <div class="well">
            <div class="row-fluid">
                <p class ="span8"><h4>Tweets</h4></p>
            </div>
            <?php
            if(!empty($userTweets)){
                foreach($userTweets as $tweet){
                    ?>
                    <div class="well">
                        <?php
                        if(!empty($tweet['Tweet']['image'])){
                            if(file_exists(WWW_ROOT . 'system' . DS . 'tweetPics' . DS . $tweet['Tweet']['image'])){
                                $img = '/system/thumbs/' . $tweet['Tweet']['image'];
                                ?>
                                <p><?php echo $this->Html->image($img, array('class' => "img-rounded")); ?></p>
                                <?php
                            }
                        }
                        ?>
                        <?php if(!$u_id && !is_numeric($u_id)){ ?>
                            <p><a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'retweet', $tweet['Tweet']['id']), true); ?>" class="btn btn-default"><?php echo $tweet['Tweet']['description']; ?></a></p>
                        <?php }else{ ?>
                            <p><?php echo $tweet['Tweet']['description']; ?></p>
                        <?php } ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

