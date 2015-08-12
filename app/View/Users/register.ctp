<div class="hero-unit">
    <div class="container">
        <div class="well">
            <div class="controls">
                <?php
                echo $this->Form->create('User', array('type' => 'file'));

                echo $this->Form->input('first_name', array(
                    'type' => 'text',
                    'label' => 'First Name*',
                    'class' => "input-xlarge"
                ));

                echo $this->Form->input('last_name', array(
                    'type' => 'text',
                    'label' => 'Last Name*',
                    'class' => "input-xlarge"
                ));

                echo $this->Form->input('username', array(
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Username*',
                    'class' => "input-xlarge"
                ));

                echo $this->Form->input('email', array(
                    'type' => 'email',
                    'required' => true,
                    'label' => 'Email*',
                    'class' => "input-xlarge"
                ));

                echo $this->Form->input('birthdate', array(
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Birth Date*',
                    'class' => "input-xlarge",
                    'id' => 'date'));

                echo $this->Form->input('password', array(
                    'type' => 'password',
                    'required' => true,
                    'label' => 'Password*',
                    'class' => "input-xlarge"
                ));

                echo $this->Form->input('confirm_password', array(
                    'type' => 'password',
                    'required' => true,
                    'label' => 'Confirm password*',
                    'id' => 'confirm_pass',
                    'class' => "input-xlarge"
                ));
                ?>
                <br>
                <?php
                echo $this->Form->input('image', array('type' => 'file', 'label' => 'File input'));
                ?>
                <br>
                <?php
                echo $this->Form->input('summary', array('type' => 'textarea', 'required' => true, 'label' => 'Summary*', 'id' => 'sum', 'class' => "input-xlarge"));
                ?>
                <p>
                    <?php
                    echo $this->Form->button('Create my account', array('type' => 'submit', 'id' => 'reg', 'class' => "btn btn-large"));
                    echo $this->Form->end();
                    ?>
                </p>

            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->css('jquery-ui'); ?>
<?php echo $this->Html->script('jquery.validate'); ?>
<script type ="text/javascript">

    $(document).ready(function() {
        $('#date').datepicker({dateFormat: "mm/dd/yy"});
       

        $("#UserRegisterForm").validate({
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
                    required: true,
                    minlength: 7
                },
                'data[User][email]': {
                    required: true
                },
                'data[User][username]': {
                    required: true,
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
