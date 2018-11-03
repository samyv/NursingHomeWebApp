<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/login.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
</head>
<body>
<div class="logo">
    <h1>GraceAge</h1>
    <h2>Providing better care</h2>
</div>

<div class="form">
    <form action="logindb.php" method="POST">
        <div class="container">
            <label for="uname"><b>Email</b></label>
            <br>
            <input type="text" placeholder="Enter email" name="email" required>
            <br>
            <label for="psw"><b>Password</b></label>
            <br>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <br>
            <span class="psw"><a href="#">Forgot password?</a></span>
            <div class="container">
            <button type="submit">Login</button>
            <button type="button">Register a new caregiver</button>
            </div>
        </div>
    </form>
</div>

<footer>
    <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
    </p>
</footer>
</body>
</html>

