<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
    <h2>User Account</h2>
    <h3>Welcome <?php echo $caregiver['firstname'], " ", $caregiver['lastname'] ; ?>!</h3>
    <div class="account-info">
        <p><b>Name: </b><?php echo $caregiver['firstname']; ?></p>
        <p><b>Email: </b><?php echo $caregiver['email']; ?></p>
        <a type="button", href="<?php echo base_url();?>Caregiver/logout" value="log out">log out</a>
    </div>
</div>
</body>
</html>