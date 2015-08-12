<div class="hero-unit">
    <div class="container">    
        <div class="well">
            <div class="controls">

                <?php
                echo $this->Form->create('Tweet', array('type' => 'file', 'controller' => 'tweets', 'action' => 'addTweet'));
                ?>
                <?php
                echo $this->Form->input('description', array(
                    'label' => false,
                    'type' => 'textarea',
                    'required' => true,
                    'placeholder' => 'Description',
                    'maxlength' => '160',
                    'onkeyup' => 'countChar(this)',
                    'after' => '</div><span id = \'myLetterCount\'>160 letters left</span></div>',
                    'id' => 'desc'));
                ?>

                <?php
                echo $this->Form->input('image', array(
                    'label' => 'File input',
                    'type' => 'file'
                ));
                ?>


                <?php
                echo $this->Form->submit('Tweet', array(
                    'class' => "btn btn-large",
                    'id' => 'submit'));
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->script('jquery.validate'); ?>
<script type ="text/javascript">
    $(document).ready(function() {

        $("#submit").attr("disabled", "disabled");
        $('#desc').keyup(function() {
            if ($(this).val() != '') {
                $("#submit").removeAttr("disabled");
                return false;
            } else {
                $("#submit").attr("disabled", "disabled");
            }
                       
        });

    });
    function countChar(val) {
        var len = val.value.length;
        if (len > 160) {
            val.value = val.value.substring(0, 160);
        } else {
            $('#myLetterCount').text(160-len+ ' letters left');
        }
    };



</script>
