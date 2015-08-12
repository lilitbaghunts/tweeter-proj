<div class="hero-unit">
    <div class="container-fluid">
        <div class="well">
            <h4>Following</h4>
            <div class="row-fluid">
                <?php if(!empty($followings)){ ?>

                    <?php foreach($followings as $following){ ?>
                        <div class ="well">
                            <?php
                            if(!empty($following['User']['image'])){
                                if(file_exists(WWW_ROOT . 'system' . DS . 'pics' . DS . $following['User']['image'])){
                                    $img = '/system/pics/' . $following['User']['image'];
                                    ?>

                                    <?php
                                }else{
                                    $img = '/img/default.jpg';
                                }
                            }else{
                                $img = '/img/default.jpg';
                            }
                            ?>

                            <p><?php echo $this->Html->image($img, array('class' => "img-rounded", 'width' => 80, 'height' => 80)); ?></p>

                            <p><a href = "<?php echo Router::url(array('controller' => 'users', 'action' => 'viewProfile', $following['User']['username']), true); ?>"><?php echo $following['User']['first_name'] . ' ' . $following['User']['last_name'] . ' (' . $following['User']['username'] . ')'; ?></a></p>

                        </div>
                    <?php } ?>

                <?php }else{
                    ?>
                    <div class="well">
                        <?php echo "Currently you are not following"; ?>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>
