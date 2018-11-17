<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/account.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <title>{page_title}</title>
</head>
<body>
<div class="grid-container">


    <div class="Header">
        <h2>User Account</h2>
        <h3>Welcome <?php echo $caregiver['firstname'], " ", $caregiver['lastname'] ; ?>!</h3>

    </div>
    <div class="settings">
        <div class= "form">
            <form action="" method="POST">
                <?php
                if(!empty($success_msg)){
                    echo '<p class="statusMsg">'.$success_msg.'</p>';

                }elseif(!empty($error_msg)){
                    echo '<p class="statusMsg">'.$error_msg.'</p>';
                }
                ?>
                <div class="form-group" id="idCaregiver">
                    <input type="number" value="<?php echo $caregiver['idCaregiver'];?>" name="idCaregiver" readonly>
                </div>
                <div class="form-group">
                    <b>First name: </b>
                    <input type="text" value="<?php echo $caregiver['firstname']; ?>" name="firstname" required="">
                    <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <b>Last name: </b>
                    <input type="text" value="<?php echo $caregiver['lastname']; ?>" name="lastname" required="">
                    <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <b>Floor: </b>
                    <input type="number" min="0" value="<?php echo $caregiver['floor']; ?>" name="floor" required="">
                    <?php echo form_error('floor','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <b>Email: </b>
                    <input type="email" value="<?php echo $caregiver['email']; ?>" name="email" required="">
                    <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <b>Old password:</b>
                    <input type="password" name="old_password" placeholder="Enter old password" required="">
                    <?php echo form_error('old_password','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <b>New password:</b>
                    <input type="password" name="new_password" placeholder="Enter new password">
                    <?php echo form_error('new_password','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <b>Confirm password:</b>
                    <input type="password" name="conf_password" placeholder="Confirm new password">
                    <?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
                </div>
			</form>
			<div class="form-group buttons">
				<input type="submit" value="Save changes" name="saveSettings"/>
				<input type="button" value="Cancel" onclick="location.href='account'"/>
			</div>
        </div>
    </div>


    <a type="button", href="<?php echo base_url();?>Caregiver/logout" value="log out">log out</a>
    <div class="footer">
        <p>hello</p>
    </div>




</div>
</body>
</html>
