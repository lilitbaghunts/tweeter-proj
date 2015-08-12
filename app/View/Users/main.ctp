<div class="hero-unit">
    <div class="container">
        <div class="well">


            <?php
            if(!empty($tweets)){
                $page = 0;
                foreach($tweets as $tweet){

                    ?>
                    <div class="well">
                        <p><a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'viewProfile', $tweet['User']['username']), true); ?>"><?php echo $tweet['User']['username']; ?></a></p>
                        <?php if(!$u_id && !is_numeric($u_id)){ ?>
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
                    <?php echo 'No tweets'; ?>
                </div>
            <?php } ?>
        </div>

        <div class="scroll">

            <a class="jscroll-next" href="<?php echo Router::url(array('controller' => 'tweets', 'action' => 'loadMore')); ?>">Load More</a>

        </div>

    </div>
</div>
<?php echo $this->Html->script('jquery.jscroll.min'); ?>

<script type ="text/javascript">
    $(document).ready(function(){
        
        $('.scroll').jscroll({
            debug: true,
            autoTrigger: false,
            //autoTriggerUntil: true,
            nextSelector: 'a:last',
            contentSelector: 'div',
            pagingSelector : ''

        });
        
    })
                

    

</script>
