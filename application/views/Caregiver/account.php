<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
    <h2>User Account</h2>
    <h3>Welcome <?php echo $caregiver['name']; ?>!</h3>
    <div class="account-info">
        <p><b>Name: </b><?php echo $caregiver['name']; ?></p>
        <p><b>Email: </b><?php echo $caregiver['email']; ?></p>
    </div>
</div>
</body>
</html>