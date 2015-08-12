<div class="well">
    <div class="container-fluid">

        <div class="span3">
            <div class="well sidebar-nav">
                <ul id="nav" class="nav nav-list">
                    <li><a id="all" class="accordion-group thumbnail" href="#">All Tweets</a></li>
                    <li><a id="my" class="accordion-group thumbnail" href="#">My Tweets</a></li>
                    <li><a id ="following" class="accordion-group thumbnail" href="#">Following tweets</a></li>
                </ul>
            </div>
        </div>

        <div class="span9">
            <div class="row-fluid">
                <div id="tweet">
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
                </div>
            </div>
        </div>

    </div>

</div>

<script type ="text/javascript">

    $(document).ready(function() {


        $('ul#nav li a').click(function(event) {
            event.preventDefault();
            if ($(this).attr('id') == 'all') {
                var url = '<?php echo Router::url(array('controller' => 'tweets', 'action' => 'allTweets')); ?>';
            } else if ($(this).attr('id') == 'my') {
                url = '<?php echo Router::url(array('controller' => 'tweets', 'action' => 'myTweets')); ?>';
            } else {
                url = '<?php echo Router::url(array('controller' => 'tweets', 'action' => 'followingTweets')); ?>';
            }
            $.ajax({
                url: url,
                success: function(data) {
                    $("#tweet").html(data);
                    return false;
                }
            })
        });
        
    });



</script>

