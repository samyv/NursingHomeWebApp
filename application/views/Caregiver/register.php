<!DOCTYPE html>
<html>
<head>
	<title>{page_title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?= base_url();?>assets/css/registerCaregiver.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/images/logo.png">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
	<script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="h1 fade-in">
	<h1>GraceAge</h1>
	<h2>Providing better care</h2>
</div>
<main>
	<div class="grid-container fade-in">
		<div class="h2">
			<h1>Register</h1>
		</div>
		<div class="register">
			<form action="" method="POST">
				<label for="nursinghome"><b>Nursing Home:</b></label>
				<div class="form-group">
					<select name="nursingHome" class="nursingHomes">

					</select>
					<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
				</div>
				<label for="surname"><b>Surname:</b></label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter first name" name="firstname" required="" value="<?php echo !empty($caregiver['firstname'])?$caregiver['firstname']:''; ?>">
					<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
				</div>
				<label for="name"><b>Name:</b></label>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter last name" name="lastname" required="" value="<?php echo !empty($caregiver['lastname'])?$caregiver['lastname']:''; ?>">
					<?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
				</div>
				<label for="email"><b>Email:</b></label>
				<br>
				<div class="form-group">
					<input type="email" class="form-control" autocomplete="username" placeholder="Enter email" name="email" required="" value="<?php echo !empty($caregiver['email'])?$caregiver['email']:''; ?>">
					<?php echo form_error('email','<span class="help-block">','</span>'); ?>
				</div>
				<label for="psw"><b>Password:</b></label>
				<br>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Enter password" name="password" required="">
					<?php echo form_error('password','<span class="help-block">','</span>'); ?>
				</div>
				<label for="psw"><b>Confirm Password:</b></label>
				<br>
				<div class="form-group">
					<input type="password" class="form-control" autocomplete="current-password" placeholder="Confirm password" name="conf_password" required="">
					<?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
				</div>
				<label for="psw"><b>Key:</b></label>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="key" name="key" required="">
					<?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
				</div>
				<div class="form-group" id="submitButtons">
					<input type="submit" name="regisSubmit" class="btn-primary" value="Register"/>
					<input type="button" onclick="location.href='index.php'" value="Go back">
				</div>
			</form>
		</div>
	</div>
</main>
<script>
	$(function () {
		let nursingHomes = <?php print_r(json_encode($nursingHomes));?>;
		for (const key of Object.keys(nursingHomes)) {
			$('.nursingHomes').append($('<option>', {value:nursingHomes[key]["NursingHomeID"], text:nursingHomes[key]["name"]}));
		}
	})
</script>
</body>
</html>
