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
			<br>
            <div class="form-group">
			    <input type="text" class="form-control" placeholder="Enter first name" name="firstname" required="" value="<?php echo !empty($user['firstname'])?$user['firstname']:''; ?>">
                <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
            </div>
			<br>
			<label for="name"><b>Name:</b></label>
			<br>
            <div class="form-group">
			    <input type="text" class="form-control" placeholder="Enter last name" name="lastname" required="" value="<?php echo !empty($user['lastname'])?$user['lastname']:''; ?>">
                <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
            </div>
			<br>
			<label for="email"><b>Email:</b></label>
			<br>
            <div class="form-group">
			    <input type="email" class="form-control" autocomplete="username" placeholder="Enter email" name="email" required="" value="<?php echo !empty($user['email'])?$user['email']:''; ?>">
                <?php echo form_error('email','<span class="help-block">','</span>'); ?>
            </div>
                <br>
			<label for="psw"><b>Password</b></label>
			<br>
            <div class="form-group">
			    <input type="password" class="form-control" placeholder="Enter password" name="password" required="">
                <?php echo form_error('password','<span class="help-block">','</span>'); ?>
            </div>
			<br>
			<label for="psw"><b>Re-enter Password</b></label>
			<br>
            <div class="form-group">
			    <input type="password" class="form-control" autocomplete="current-password" placeholder="Confirm password" name="conf_password" required="">
                <?php echo form_error('confirm_password','<span class="help-block">','</span>'); ?>
            </div>
			<br>
            <div class="form-group">
                <input type="submit" name="regisSubmit" class="btn-primary"/>
            </div>
            <button type="button" onclick="location.href='index.php'">Go back</button>
	</form>
</div>

<footer>
	<p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
	</p>
</footer>
</body>
</html>

