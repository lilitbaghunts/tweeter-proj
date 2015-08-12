<div class="hero-unit">
    <div class="container">    
        <div class="well">
            <div class="controls">
                <?php
                if (file_exists(WWW_ROOT . 'system' . DS . 'pics' . DS . $user['User']['image'])) {
                    $img = '/system/pics/' . $user['User']['image'];
                    ?>
                    <p><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'uploadPhoto'), true); ?>"><?php echo $this->Html->image($img, array('class' => "img-rounded", 'width' => 180, 'height' => 180)); ?></a></p>
                <?php } ?>

                <?php echo $this->Form->create('User', array('type' => 'file', 'controller' => 'users', 'action' => 'uploadPhoto')); ?>
                <?php echo $this->Form->hidden('id', array('value' => $user['User']['id'])); ?>
                <?php echo $this->Form->input('image', array('type' => 'file', 'label' => 'File input')); ?>
                <?php
                echo $this->Form->submit('Save', array('class' => "btn btn-large"));
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
