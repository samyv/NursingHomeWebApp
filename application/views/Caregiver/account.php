<!DOCTYPE html>
<html lang="en">
<head>
	<link href="<?php echo base_url(); ?>assets/css/account.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<title>{page_title}</title>
</head>
<body>
<form action="" method="post">
	<?php
	if(!empty($success_msg)){
		echo '<p class="statusMsg">'.$success_msg.'</p>';

	}elseif(!empty($error_msg)){
		echo '<p class="statusMsg">'.$error_msg.'</p>';
	}
	?>
	<div class="grid-container">
		<div class="header">
			<h3>Change Account Settings</h3>
		</div>
		<div class="firstname">
			<b>First name: </b>
		</div>
		<div class="firstname_input">
			<input type="text" value="<?php echo $caregiver['firstname']; ?>" name="firstname" required="">
			<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="lastname">
			<b>Last name: </b>
		</div>
		<div class="lastname_input">
			<input type="text" value="<?php echo $caregiver['lastname']; ?>" name="lastname" required="">
			<?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="floor">
			<b>Floor: </b>
		</div>
		<div class="floor_input">
			<input type="number" min="0" value="<?php echo $caregiver['floor']; ?>" name="floor" required="">
			<?php echo form_error('floor','<span class="help-block">','</span>'); ?>
		</div>
		<div class="email">
			<b>Email: </b>
		</div>
		<div class="email_input">
			<input type="email" value="<?php echo $caregiver['email']; ?>" name="email" required="">
			<?php echo form_error('email','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="old_pass">
			<b>Old password: </b>
		</div>
		<div class="old_pass_input">
			<input type="password" name="old_password" placeholder="Enter old password" required="">
			<?php echo form_error('old_password','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="new_pass">
			<b>New password: </b>
		</div>
		<div class="new_pass_input">
			<input type="password" name="new_password" placeholder="Enter new password">
			<?php echo form_error('new_password','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="conf_pass">
			<b>Confirm password: </b>
		</div>
		<div class="conf_pass_input">
			<input type="password" name="conf_password" placeholder="Confirm new password">
			<?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
		</div>
	</div>
	<div class="buttons">
		<input type="submit" value="Save changes" name="saveSettings"/>
		<input type="button" value="Cancel" onclick="location.href='account'"/>
	</div>
</form>
</body>
</html>
