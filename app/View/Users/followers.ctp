<div class="hero-unit">
    <div class="container-fluid">
        <div class="well">
            <h4>Followers</h4>
            <div class="row-fluid">
                <?php if(!empty($followers)){ ?>

                    <?php foreach($followers as $follower){ ?>
                        <div class ="well">
                            <?php
                            if(!empty($follower['User']['image'])){
                                if(file_exists(WWW_ROOT . 'system' . DS . 'pics' . DS . $follower['User']['image'])){
                                    $img = '/system/pics/' . $follower['User']['image'];
                                }else{
                                    $img = '/img/default.jpg';
                                }
                            }else{
                                $img = '/img/default.jpg';
                            }
                            ?>
                            <p><?php echo $this->Html->image($img, array('class' => "img-rounded", 'width' => 80, 'height' => 80)); ?></p>

                            <p><a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'viewProfile', $follower['User']['username']), true); ?>"><?php echo $follower['User']['first_name'] . ' ' . $follower['User']['last_name'] . ' (' . $follower['User']['username'] . ')'; ?></a></p>

                        </div>
                    <?php } ?>

                <?php }else{
                    ?>
                    <div class="well">
                        <?php echo "No followers"; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
