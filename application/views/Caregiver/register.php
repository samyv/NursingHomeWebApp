<!DOCTYPE html>
<html>
<head>
	<title>{page_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?= base_url();?>assets/css/registerCaregiver.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
	<script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<main>
	<div class="grid-container fade-in">
		<div class="h2">
			<h1> <?php echo ($this->lang->line('register'))?></h1>
		</div>
		<div class="register">
            <?php
            if(!empty($success_msg)){
                echo '<p class="statusMsg">'.$success_msg.'</p>';
            }elseif(!empty($error_msg)){
                echo '<p class="statusMsg">'.$error_msg.'</p>';
            }
            ?>
			<form action="" method="POST">
				<label for="nursinghome"><b> <?php echo ($this->lang->line('nursing home'))?></b></label>
				<div class="form-group">
					<select name="nursingHome" class="nursingHomes">

					</select>
					<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
				</div>
				<label for="surname"><b> <?php echo ($this->lang->line('firstname'))?></b></label>
				<div class="form-group">
					<input type="text" class="form-control" placeholder=" <?php echo ($this->lang->line('ph firstname'))?>" name="firstname" required="" value="<?php echo (isset($_POST['firstname']) ? $_POST['firstname'] : ''); ?>">
					<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
				</div>
				<label for="name"><b> <?php echo ($this->lang->line('lastname'))?></b></label>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" placeholder=" <?php echo ($this->lang->line('ph lastname'))?>" name="lastname" required="" value="<?php echo (isset($_POST['lastname']) ? $_POST['lastname'] : ''); ?>">
					<?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
				</div>
				<label for="email"><b> <?php echo ($this->lang->line('email'))?></b></label>
				<br>
				<div class="form-group">
					<input type="email" class="form-control" autocomplete="username" placeholder=" <?php echo ($this->lang->line('ph email'))?>" name="email" required="" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
					<?php echo form_error('email','<span class="help-block">','</span>'); ?>
				</div>
				<label for="psw"><b><?php echo ($this->lang->line('password'))?></b></label>
				<br>
				<div class="form-group">
					<input type="password" class="form-control" placeholder=" <?php echo ($this->lang->line('ph password'))?>" name="password" required="">
					<?php echo form_error('password','<span class="help-block">','</span>'); ?>
				</div>
				<label for="psw"><b> <?php echo ($this->lang->line('confirm password'))?></b></label>
				<br>
				<div class="form-group">
					<input type="password" class="form-control" autocomplete="current-password" placeholder=" <?php echo ($this->lang->line('ph confirm password'))?>" name="conf_password" required="">
					<?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
				</div>
				<label for="psw"><b> <?php echo ($this->lang->line('key'))?></b></label>
				<br>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="key" name="key" required="">
					<?php echo form_error('key','<span class="help-block">','</span>'); ?>
				</div>
				<div class="form-group" id="submitButtons">
					<input type="submit" name="regisSubmit" class="btn-primary" value=" <?php echo ($this->lang->line('register'))?>"/>
					<input type="button" onclick="location.href='index.php'" value=" <?php echo ($this->lang->line('cancel'))?>">
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
