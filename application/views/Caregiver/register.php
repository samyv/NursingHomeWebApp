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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg fade-in">
        <h1 class="navbar-text ml-lg-auto header-title">
            GraceAge<br>
            <div><h2><?php echo ($this->lang->line('subtitle header'))?></h2></div>
        </h1>
        <div class="nav-item dropdown ml-md-auto">
            <a class="nav-link" href="#" id="language" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-globe-americas"></i>
            </a>
            <?php
            // set pathname from where we came from
            $pn=uri_string();  // the uri class is initialized automatically
            ?>
            <div class="dropdown-menu dropdown-menu-right">
                <a class = dropdown-item href='<?php echo base_url()?>languageSwitcher/switchLanguage/english?<?=$pn?>'>
                    <?php echo ($this->lang->line('english'))?></a>
                <a class = dropdown-item href='<?php echo base_url()?>languageSwitcher/switchLanguage/Nederlands?<?=$pn?>'>
                    <?php echo ($this->lang->line('dutch'))?></a>
            </div>
        </div>
    </nav>
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
