<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/login.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
<div class="h1">
    <h1>GraceAge</h1>
    <h2>Providing better care</h2>
</div>
    <div class="grid-container">
        <div class="image">
            <img id="remyImg" src="<?=base_url();?>assets/images/edouard-remy.jpg" >
        </div>

        <div class="login-form">
            <?php
            if(!empty($success_msg)){
                echo '<p class="statusMsg">'.$success_msg.'</p>';
            }elseif(!empty($error_msg)){
                echo '<p class="statusMsg">'.$error_msg.'</p>';
            }
            ?>
            <form action="" method="POST">
                    <label for="email"><b>Email</b></label>
                    <br>
                    <div class="form-group has-feedback">
                        <input id="emailField" class="form-control" type="email" placeholder="Enter email" name="email" required="" value="">
                        <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                    </div>
                    <br>
                    <label for="psw"><b>Password</b></label>
                    <br>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Enter Password" name="password" required="">
                        <?php echo form_error('password','<span class="help-block">','</span>'); ?>
                    </div>
                    <br>
                    <span class="psw"><a href="#" id="FPModal">Forgot password?</a></span>
                    <div class="form-group" id="submitButtons">
                        <input type="submit" name="loginSubmit" value="Login"/>
                        <input type="button" value="Register" onclick="location.href='register'"/>
                    </div>
            </form>
			<form method="get">

			</form>
        </div>
    </div>

<div class="modal-content" id="forgot-password-modal-content">
    <div class="modal-header">
        <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span>Recover Password</h4>
    </div>
    <form action="" method="post" name="submitEmail">
    <div class="modal-body">

            <p>Please fill in your email so we can send you a link to reset your password.</p>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <input name="email" id="email" type="email" class="form-control input-lg" placeholder="Enter Email">
                </div>
            </div>

    </div>
    <div class="modal-footer">
        <input type="submit" id="submitEmail" name="submitEmail" class="btn btn-block btn-lg" value="Submit">
    </div>
    </form>

</div>
<!-- forgot password content -->



</body>
</html>

<script>
    $(document).ready(function () {
        $('#FPModal').click(function(){
            $('#forgot-password-modal-content').fadeIn('fast');
        });

        $('#closemodal').click(function () {
            $('#forgot-password-modal-content').fadeOut('fast');
        })

        $('#submitEmail').click(submitEmail)

    });

    function submitEmail(event){

        $email = $('#email').val();

        console.log($email);
        $.ajax({
            url: '<?php echo base_url();?>Caregiver/createPasswordMail',
            method: 'post',
            dataType: 'json',
            data:{
                'email' : $email
            },
            success: showmsg(event)
        });
    }

    //test
    function showmsg(event) {
        $button = $(event.target).parent();
        $form = $(event.target).parent().prev().children();
        $modalBody = $(event.target).parent().prev();

        $form.remove();
        $button.remove();
        $modalBody.append("<p>A link to reset your password has been sent to " + $email + ".</p>");

    }

</script>



