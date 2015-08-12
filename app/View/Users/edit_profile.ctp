
<div class="hero-unit">
    <div class="container">    
        <div class="well">
            <div class="controls">

                <?php
                echo $this->Form->create('User', array('controller' => 'users', 'action' => 'editProfile'));
                ?>
                <?php echo $this->Form->hidden('id', array('value' => $user['User']['id'])); ?>
                <?php
                echo $this->Form->input('first_name', array('type' => 'text', 'value' => $user['User']['first_name'], 'required' => true, 'label' => 'First Name', 'class' => "input-xlarge"));
                ?>
                <?php
                echo $this->Form->input('last_name', array('type' => 'text', 'value' => $user['User']['last_name'], 'required' => true, 'label' => 'Last Name', 'class' => "input-xlarge"));

                echo $this->Form->input('email', array('type' => 'text', 'value' => $user['User']['email'], 'required' => true, 'label' => 'Email', 'class' => "input-xlarge"));
                ?>
                <?php
                echo $this->Form->input('birthdate', array('type' => 'text', 'id' => 'date', 'value' => $user['User']['birthdate'], 'required' => true, 'label' => 'Birth Date', 'class' => "input-xlarge", 'id' => 'date'));
                ?>

                <?php
                echo $this->Form->input('summary', array('type' => 'textarea', 'value' => $user['User']['summary'], 'required' => true, 'label' => 'Summary', 'id' => 'sum', 'class' => "input-xlarge"));
                ?>

                <?php
                echo $this->Form->submit('Save', array('id' => 'reg', 'name'=>'submit', 'class' => "btn btn-large btn-success"));
                ?>
                <p>  
                    <?php
                    echo $this->Form->submit('Cancel', array('name' => 'cancel', 'id' => 'reg', 'class' => "btn btn-large"));
                    echo $this->Form->end();
                    ?>
                </p>

            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->css('jquery-ui'); ?>
<?php echo $this->Html->script('jquery.validate'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('#date').datepicker({dateFormat: "mm/dd/yy"});
        
        $('#UserEditProfileForm').validate({
            rules: {
                'data[User][first_name]': {
                    required: true
                },
                'data[User][last_name]': {
                    required: true
                },
                'data[User][birthdate]':{
                    required: true
                },
                'data[User][password]': {
                     minlength: 7
                },
                'data[User][email]': {
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