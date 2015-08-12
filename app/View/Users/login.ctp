<div class="hero-unit">
    <div class="container">
        <div class="well">
            <div class="controls">
                <?php
                echo $this->Form->create('User');
                echo $this->Form->input('username_or_email', array(
                    'type' => 'text',
                    'label' => 'Username or email',
                    'class' => "input-xlarge"
                ));
                echo $this->Form->input('password', array(
                    'type' => 'password',
                    'label' => 'Password',
                    'class' => "input-xlarge"
                ));

                echo $this->Form->button('Sign in', array(
                    'type' => 'submit',
                    'class' => 'btn btn-success'
                ));

                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>

<?php  echo $this->Html->script('jquery.validate'); ?>

<script type ="text/javascript">
    $(document).ready(function(){
        $("#UserLoginForm").validate({
            rules:{
                'data[User][username_or_email]':{
                    required: true
                },
                'data[User][password]':{
                    required: true
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