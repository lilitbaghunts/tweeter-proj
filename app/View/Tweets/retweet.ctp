<div class="hero-unit">
    <div class="container">    
        <div class="well">
            <div class="controls">

                <?php
                echo $this->Form->create('Tweet');
                ?>
                <?php
                if (file_exists(WWW_ROOT . 'system' . DS . 'thumbs' . DS . $retweet['Tweet']['image'])) {
                    $img = '/system/thumbs/' . $retweet['Tweet']['image'];
                    ?>
                    <p><?php echo $this->Html->image($img, array('class' => "img-rounded", 'width' => 80, 'height' => 80)); ?></p>
                <?php } ?>
                <?php
                echo $this->Form->input('description', array(
                    'label' => false,
                    'type' => 'textarea',
                    'value' => $retweet['Tweet']['description'],
                    'disabled' => true,
                    'rows' => '3'
                ));
                echo $this->Form->input('retweet', array(
                    'label' => false,
                    'type' => 'textarea',
                    'maxlength' => '100',
                    'rows' => '4',
                    'after' => '<span class = \'help-inline\'>Maximum of 100 characters.</span></div>'
                ));
                ?>


                <?php
                echo $this->Form->submit('Retweet', array(
                    'class' => "btn btn-large",
                    'id' => 'submit'));
                echo $this->Form->end();
                ?>    
            </div>
        </div>
    </div>
</div>



