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
                    <p><?php echo $this->Html->image($img, array('class' => "img-rounded")); ?></p>
                    <?php
                }
            }
            ?>
            <?php if($tweet['Tweet']['user_id'] == $u_id){ ?>
                <p><a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'myProfile')); ?>"><?php echo $tweet['User']['username']; ?></a></p>
            <?php }else{ ?>
                <p><a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'viewProfile', $tweet['User']['username']), true); ?>"><?php echo $tweet['User']['username']; ?></a></p>
            <?php } ?>
            <?php if($tweet['Tweet']['user_id'] !== $u_id){ ?>
                <p><a href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'retweet', $tweet['Tweet']['id']), true); ?>" class="btn btn-default"><?php echo $tweet['Tweet']['description']; ?></a></p>
            <?php }else{ ?>
                <p><?php echo $tweet['Tweet']['description']; ?></p>
            <?php } ?>
        </div>
        <?php
    }
}else{
    ?>
    <div class="well">
        <?php echo 'No tweets yet.'; ?>
    </div>
<?php } ?>
<div class="well" id="more_updates"></div>
<div class="well" id="morebutton" >

    <a id="more" class="more btn" >
        Load More </a>
</div>

<script type ="text/javascript">
    var page = 0;
    $(document).ready(function() {
        $('#morebutton').click(function() {
            page++
            $.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'tweets', 'action' => 'loadMore')); ?>" + '/' + page,
                data: {
                    page: page
                },
                success: function(html) {
                    $("#more_updates").append(html);
                    //$("#morebutton").remove();  

                }
            });
            return false;

        });
    });

</script>
