<div class="hero-unit">
    <div class="container">    
        <div class="well">
            <div class="controls">
                <?php
                echo $this->Form->create('User', array('controller' => 'users', 'action' => 'changePassword'));
                ?>
                <?php echo $this->Form->hidden('id', array('value' => $user['User']['id'])); ?>
                <br><p>Change Password</p>
                <?php
                echo $this->Form->input('password', array('type' => 'password', 'label' => 'New Password', 'id' => 'pass', 'class' => "input-xlarge"));
                ?>
                <?php
                echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => 'Confirm Password*', 'id' => 'confirm_pass', 'class' => "input-xlarge"));
                ?>
                <?php
                echo $this->Form->submit('Save', array('id' => 'reg', 'class' => "btn btn-large btn-success"));
                ?>
                <br>  

                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'myProfile'), true); ?>" class="btn btn-large">Cancel</a>

                <?php echo $this->Form->end();
                ?>

            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->script('jquery.validate'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('#UserChangePasswordForm').validate({
            rules: {
                
                'data[User][password]': {
                    minlength: 7
                }
               
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error').addClass('success');
            }
        });

    });
</script>  
