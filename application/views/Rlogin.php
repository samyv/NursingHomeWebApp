<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/loginResident.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
</head>
<body>
<div class="logo">
    <h1>GraceAge</h1>
    <h2>Providing better care</h2>
</div>

<div class="form">
    <form action="logindbResident.php" method="POST">
        <div class="container">
            <label for="uname"><b>Room number</b></label>
            <br>
            <input id="roomField" type="number" min="0" placeholder="Enter room number" name="room_number">
            <br>
            <button id = "loginResident" type="submit" value="Submit">Login</button>
        </div>
    </form>
</div>

<footer>
    <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
    </p>
</footer>
</body>
</html>


