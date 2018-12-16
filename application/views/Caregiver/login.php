<!DOCTYPE html>
<html>
<head>
	<title>{page_title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?=base_url()?>assets/css/login.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
	<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/transitions.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
</head>

<body>

		<div class="h1 fade-in">
            <h1>GraceAge</h1>
			<h2> <?php echo ($this->lang->line('subtitle header'))?></h2>

		</div>
		<div class="modal-content" id="forgot-password-modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span> <?php echo ($this->lang->line('title forgot pass'))?></h4>
			</div>
			<form action="" method="post" name="submitEmail">
				<div class="modal-body">
					<p> <?php echo ($this->lang->line('text forgot pass'))?></p>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
							<input name="email" id="email" type="email" class="form-control input-lg" placeholder=" <?php echo ($this->lang->line('ph email'))?>">
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="submit" id="submitEmail" name="submitEmail" class="btn btn-block btn-lg" value=" <?php echo ($this->lang->line('send'))?>">
				</div>
			</form>

		</div>
		<div class="grid-container fade-in">
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
					<label for="email"><b> <?php echo ($this->lang->line('email'))?></b></label>
					<br>
					<div class="form-group has-feedback">
						<input id="emailField" class="form-control" type="email" placeholder=" <?php echo ($this->lang->line('ph email'))?>" name="email" required="" value="">
						<?php echo form_error('email','<span class="help-block">','</span>'); ?>
					</div>
					<br>
					<label for="psw"><b> <?php echo ($this->lang->line('password'))?></b></label>
					<br>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="<?php echo ($this->lang->line('ph password'))?>" name="password" required="">
						<?php echo form_error('password','<span class="help-block">','</span>'); ?>
					</div>
					<br>
					<span class="psw"><a href="#" id="FPModal"> <?php echo ($this->lang->line('forgot password'))?></a></span>
					<div class="form-group" id="submitButtons">
						<input type="submit" name="loginSubmit" value=" <?php echo ($this->lang->line('login'))?>"/>
						<input type="button" value=" <?php echo ($this->lang->line('register'))?>" onclick="location.href='register'"/>
					</div>
				</form>
			</div>
		</div>
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

	function showmsg(event) {
		$button = $(event.target).parent();
		$form = $(event.target).parent().prev().children();
		$modalBody = $(event.target).parent().prev();

		$form.remove();
		$button.remove();
		$modalBody.append("<p> <?php echo ($this->lang->line('link'))?> " + $email + ".</p>");

	}

</script>
</body>
</html>




