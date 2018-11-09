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
	<form action="registerdbCaregiver.php" method="POST">
		<div class="container">
			<label for="surname"><b>Surname:</b></label>
			<br>
			<input type="text" autocomplete="username" placeholder="Enter surname..." name="firstname" required>
			<br>
			<label for="name"><b>Name:</b></label>
			<br>
			<input type="text" autocomplete="username" placeholder="Enter Name..." name="lastname" required>
			<br>
			<label for="email"><b>Email:</b></label>
			<br>
			<input type="text" autocomplete="username" placeholder="Enter email..." name="email" required>
			<br>
			<label for="psw"><b>Password</b></label>
			<br>
			<input type="password" autocomplete="current-password" placeholder="Enter Password..." name="psw" required>
			<br>
			<label for="psw"><b>Re-enter Password</b></label>
			<br>
			<input type="password" autocomplete="current-password" placeholder="Re-enter Password..." name="psw2" required>
			<br>
            <button type="button" onclick="location.href='index.php'">Go back</button>
			<button type="submit">Register</button>
		</div>
	</form>
</div>

<footer>
	<p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
	</p>
</footer>
</body>
</html>

