<?php
if(!empty($followings)){
    foreach($followings as $following){
        ?>
        <div class="well" >
            <?php
            if(file_exists(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $following['Tweet']['image'])){
                $img = '/system/thumbs/' . $following['Tweet']['image'];
                ?>
                <p><?php echo $this->Html->image($img, array('class' => "img-rounded")); ?></p>
            <?php } ?>
            <p>   <a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'viewProfile', $following['User']['username']), true); ?>"><?php echo $following['User']['username']; ?></a></p>
            <p>   <a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'retweet', $following['Tweet']['id']), true); ?>" class="btn btn-default"><?php echo $following['Tweet']['description']; ?></a></p>
        </div>
        <?php
    }
}else{
    ?>
    <div class="well">
        <?php echo 'Currently you are not following'; ?>
    </div>
<?php } ?>