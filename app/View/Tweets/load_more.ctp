<?php
if(!empty($tweets)){
    foreach($tweets as $tweet){
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
            <p><a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'viewProfile', $tweet['User']['username']), true); ?>"><?php echo $tweet['User']['username']; ?></a></p>
            <?php if($tweet['Tweet']['user_id'] !== $u_id){ ?>
                <p><a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'retweet', $tweet['Tweet']['id']), true); ?>" class="btn btn-default"><?php echo $tweet['Tweet']['description']; ?></a></p>
            <?php }else{ ?>
                <p><?php echo $tweet['Tweet']['description']; ?></p>
            <?php } ?>
        </div>
        <?php
    }
     echo $this->Paginator->numbers();
}else{
    ?>
    <div class="well">
        <?php echo 'No more tweets to show'; ?>
    </div>
<?php } ?>


