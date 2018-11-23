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
		<div class="h1">
			<h3>Change Account Settings</h3>
		</div>
		<div class="form-left">
			<b>First name: </b>
			<br>
			<b>Last name: </b>
			<br>
			<b>Floor: </b>
		</div>
		<div class="form-left-input">
			<input type="text" value="<?php echo $caregiver['firstname']; ?>" name="firstname" required="">
			<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
			<br>

			<input type="text" value="<?php echo $caregiver['lastname']; ?>" name="lastname" required="">
			<?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
			<br>

			<input type="number" min="0" value="<?php echo $caregiver['floor']; ?>" name="floor" required="">
			<?php echo form_error('floor','<span class="help-block">','</span>'); ?>
		</div>
		<div class="form-right">
			<b>Email: </b>
			<br>
			<b>Old password:</b>
			<br>
			<b>New password:</b>
			<br>
			<b>Confirm password:</b>
		</div>
		<div class="form-right-input">
			<input type="email" value="<?php echo $caregiver['email']; ?>" name="email" required="">
			<?php echo form_error('email','<span class="help-block">','</span>'); ?>
			<br>

			<input type="password" name="old_password" placeholder="Enter old password" required="">
			<?php echo form_error('old_password','<span class="help-block">','</span>'); ?>
			<br>

			<input type="password" name="new_password" placeholder="Enter new password">
			<?php echo form_error('new_password','<span class="help-block">','</span>'); ?>
			<br>

			<input type="password" name="conf_password" placeholder="Confirm new password">
			<?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
		</div>
		<div class="buttons">
			<input type="submit" value="Save changes" name="saveSettings"/>
			<input type="button" value="Cancel" onclick="location.href='account'"/>
		</div>
	</div>
</form>
</body>
</html>
