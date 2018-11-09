<!DOCTYPE html>
<html>
<head>
	<title>{page_title}</title>
	<link href="<?= base_url() ?>assets/css/login.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/images/logo.png">
</head>
<body>
<div class="logo">
	<h1>GraceAge</h1>
	<h2>Providing better care</h2>
</div>

<div class="form">
	<form action="" method="POST">
			<label for="surname"><b>Surname:</b></label>
            <div class="form-group">
			    <input type="text" class="form-control" placeholder="Enter first name" name="firstname" required="" value="<?php echo !empty($user['firstname'])?$user['firstname']:''; ?>">
                <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
            </div>
			<label for="name"><b>Name:</b></label>
			<br>
            <div class="form-group">
			    <input type="text" class="form-control" placeholder="Enter last name" name="lastname" required="" value="<?php echo !empty($user['lastname'])?$user['lastname']:''; ?>">
                <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
            </div>
			<label for="email"><b>Email:</b></label>
			<br>
            <div class="form-group">
			    <input type="email" class="form-control" autocomplete="username" placeholder="Enter email" name="email" required="" value="<?php echo !empty($user['email'])?$user['email']:''; ?>">
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
                <?php echo form_error('confirm_password','<span class="help-block">','</span>'); ?>
            </div>
			<div class="form-group">
                <input type="submit" name="regisSubmit" class="btn-primary"/>
                <input type="submit" onclick="location.href='index.php'" value="Go back">
            </div>
	</form>
</div>

<footer>
	<p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
	</p>
</footer>
</body>
</html>

