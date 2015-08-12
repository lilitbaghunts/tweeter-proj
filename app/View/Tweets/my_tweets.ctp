<?php
if(!empty($myTweets)){
    foreach($myTweets as $myTweet){
        ?>
        <div class="well" >
            <?php
            if(!empty($myTweet['Tweet']['image'])){
                if(file_exists(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $myTweet['Tweet']['image'])){
                    $img = '/system/thumbs/' . $myTweet['Tweet']['image'];
                    ?>
                    <p><?php echo $this->Html->image($img, array('class' => "img-rounded")); ?></p>
                    <?php
                }
            }
            ?>
        <!--            <p>   <?php echo $myTweet['User']['username']; ?></p>-->
            <p>   <?php echo $myTweet['Tweet']['description']; ?></p>
        </div>
        <?php
    }
}
?>
