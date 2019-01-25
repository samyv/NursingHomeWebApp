<!DOCTYPE html>
<html lang="en">
<head>
	<link href="<?php echo base_url(); ?>assets/css/account.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>{page_title}</title>
</head>
<body>
<form class="fade-in" action="" method="post">

	<?php
	if(!empty($success_msg)){
		echo '<p class="statusMsg">'.$success_msg.'</p>';

	}elseif(!empty($error_msg)){
		echo '<p class="statusMsg">'.$error_msg.'</p>';
	}
	?>
	<div class="grid-container">
		<div class="header">
			<h3><?php
                echo ($this->lang->line('title account'));?>
            </h3>
		</div>
		<div class="firstname">
			<b> <?php
                echo ($this->lang->line('firstname'));?>
            </b>
		</div>
		<div class="firstname_input">
			<input type="text" value="<?php echo $caregiver['firstname']; ?>" class = "form-control" name="firstname" required="">
			<?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="lastname">
			<b><?php
                echo ($this->lang->line('lastname'));?>
            </b>
		</div>
		<div class="lastname_input">
			<input type="text" value="<?php echo $caregiver['lastname']; ?>"  class = "form-control"name="lastname" required="">
			<?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="floor">
			<b><?php
                echo ($this->lang->line('floor'));?>
            </b>
		</div>
		<div class="floor_input">
			<input type="number" min="0" value="<?php echo $caregiver['floor']; ?>"  class = "form-control" name="floor" required="">
			<?php echo form_error('floor','<span class="help-block">','</span>'); ?>
		</div>
		<div class="email">
			<b><?php
                echo ($this->lang->line('email'));?>
            </b>
		</div>
		<div class="email_input">
			<input type="email" value="<?php echo $caregiver['email']; ?>"  class = "form-control" name="email" required="">
			<?php echo form_error('email','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="old_pass">
			<b><?php
                echo ($this->lang->line('old password'));?>
            </b>
		</div>
		<div class="old_pass_input">
			<input type="password" name="old_password" class = "form-control" required=""
                   placeholder="<?php echo ($this->lang->line('ph old password'));?>">
			<?php echo form_error('old_password','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="new_pass">
			<b><?php
                echo ($this->lang->line('new password'));?>
            </b>
		</div>
		<div class="new_pass_input">
			<input type="password" name="new_password" class = "form-control"
                   placeholder="<?php echo ($this->lang->line('ph new password'));?>">
			<?php echo form_error('new_password','<span class="help-block">','</span>'); ?>
			<br>
		</div>
		<div class="conf_pass">
			<b><?php
                echo ($this->lang->line('confirm password'));?>
            </b>
		</div>
		<div class="conf_pass_input">
			<input type="password" name="conf_password"  class = "form-control"
                   placeholder="<?php echo ($this->lang->line('ph confirm password'));?>">
			<?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
		</div>
		<div class="fk_pref">
			<b><?php
				echo ($this->lang->line('fk pref'));?>
			</b>
		</div>
		<div id = "checkboxFloors" class="fk_pref_input">
		</div>
        <div class="buttons">
            <input type="submit" name="saveSettings"
                   value=<?php echo ($this->lang->line('save'));?> />
            <input type="button" onclick="location.href='landingpage'"
                   value=<?php echo ($this->lang->line('cancel'));?> />
        </div>
	</div>

</form>
<script>
	$(function () {
		var floors = [<?php echo '"'.implode('","', $floors).'"' ?>];
		i = 0;
		floors.forEach(function (e) {
			var floorFK = floors[i]
			console.log(floorFK)
			i++;
			namee = "f"+i
			$('#checkboxFloors').append(" "+i+": ");
			var child1 = undefined;
			if(floorFK == 1) {
				child = $("<input type='checkbox' name=" + namee+" checked>");
			} else {
				child = $("<input type='checkbox' name=" + namee+" >");
			}

			$('#checkboxFloors').append(child);


		})
	})

</script>
</body>
</html>
