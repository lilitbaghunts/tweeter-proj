<div class="hero-unit">
    <div class="container">
        <div class="well">

            <?php if(!empty($user)){ ?> 
                <?php if(!empty($follower)){ ?>           
                    <p> <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'unfollow', $user['User']['id']), true); ?>">Unfollow</a></p>
                <?php }else{ ?>
                    <p> <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'follow', $user['User']['id']), true); ?>">Follow</a></p>


                <?php } ?>


                <p><?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></p>
                <p><?php echo $user['User']['username']; ?></p>
                <p><?php echo $user['User']['email']; ?></p>
                <p><?php echo date('m/d/Y', strtotime($user['User']['birthdate'])); ?></p>
                <p><?php echo $user['User']['summary']; ?></p>
                <?php
                if(!empty($user['User']['image'])){
                    if(file_exists(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $user['User']['image'])){
                        $img = '/system/thumbs/' . $user['User']['image'];
                    }else{
                        $img = '/img/default.jpg';
                    }
                }else{
                    $img = '/img/default.jpg';
                    ?>
                    <p><?php echo $this->Html->image($img, array('class' => "img-rounded")); ?></p>
                <?php } ?>


            </div>

            <div class="well">
                <div class="row-fluid">
                    <p class ="span8"><h4>Tweets</h4></p>
                </div>
                <?php
                if(!empty($userTweets)){
                    foreach($userTweets as $tweet){
                        ?>
                        <div class="well" >
                            <?php
                            if(!empty($tweet['Tweet']['image'])){
                                if(file_exists(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $tweet['Tweet']['image'])){
                                    $img = '/system/thumbs/' . $tweet['Tweet']['image'];
                                    ?>
                                    <p><?php echo $this->Html->image($img, array('class' => "img-rounded", 'width' => 80, 'height' => 80)); ?></p>
                                    <?php
                                }
                            }
                            ?>
                            <p><a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'retweet', $tweet['Tweet']['id']), true); ?>" class="btn btn-default"><?php echo $tweet['Tweet']['description']; ?></a></p>
                        </div>
                        <?php
                    }
                }else{
                    echo $user['User']['username'] . ' has no tweets';
                }
                ?>
            <?php } ?>
        </div>
    </div>
</div>


