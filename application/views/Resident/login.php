<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/loginResident.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>assets/js/Resident/login.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="logo">
    <h1>GraceAge</h1>
    <h2>Providing better care</h2>
</div>

<!-- form to submit the room number -->
<div class="form">
    <form action="" method="POST">
        <div class="form-group">
            <label for="roomField"><b>Room number</b></label>
            <input type="number" min="0" placeholder="Enter room number" name="room_number" required="">
            <?php echo form_error('room_number','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input id="loginButton" name="loginResident" type="submit" value="Login">
        </div>
    </form>
</div>

<!--create buttons for each resident in the room, the form is so you can parse the right data to the session-->
{residentNames}
<form method="post">
    <input type="submit" name="selectResident{residentID}" class="ResidentButton" value="{firstname} {lastname}">
</form>
{/residentNames}

<footer>
    <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
    </p>
</footer>
</body>
</html>