<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/newResident.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>{page_title}</title>
</head>
<body>
<form action="" method="post">
    //copied from account:
    <?php
    if(!empty($success_msg)){
        echo '<p class="statusMsg">'.$success_msg.'</p>';

    }elseif(!empty($error_msg)){
        echo '<p class="statusMsg">'.$error_msg.'</p>';
    }
    ?>
    //
    <div class="grid-container">
        <div class="header">
            <h3>Register a new resident</h3>
        </div>
        <div class = "resident">
            <h3>Resident information</h3>
        </div>

        <div class="firstname">
            <b>First name: </b>
        </div>
        <div class="firstname_input">
            <input type="text" name="first_name" placeholder="First name" required="">
            <?php echo form_error('first_name','<span class="help-block">','</span>'); ?>
            <br>
        </div>
        <div class="lastname">
            <b>Last name: </b>
        </div>
        <div class="lastname_input">
            <input type="text" name="last_name" placeholder="Last name">
            <?php echo form_error('last_name','<span class="help-block">','</span>'); ?>
            <br>
        </div>
        <div class="birthday">
            <b>Birthday: </b>
        </div>
        <div class="birthday_input">
            <input type="date" name="birthday" placeholder="">
            <?php echo form_error('birthday','<span class="help-block">','</span>'); ?>
        </div>
        <div class="gender">
            <b>Gender: </b>
        </div>
        <div class="gender_input">
            <select>
                <option value="choose">choose</option>
                <option value="male">male</option>
                <option value="female">female</option>
            </select>
            <?php echo form_error('room','<span class="help-block">','</span>'); ?>
        </div>
        <div class="floor">
            <b>Floor: </b>
        </div>
        <div class="floor_input">
            <input type="number" name="floor" placeholder="Floor number">
            <?php echo form_error('floor','<span class="help-block">','</span>'); ?>
        </div>
        <div class="room">
            <b>Room: </b>
        </div>
        <div class="room_input">
            <input type="number" name="room" placeholder="Room number">
            <?php echo form_error('room','<span class="help-block">','</span>'); ?>
        </div>

        <div class="extra">
            <h3>Contact information</h3>
        </div>
        <div class="contact_name">
            <b>Name: </b>
        </div>
        <div class="contact_name_input">
            <input type="text" name="full_name" placeholder="First Last" required="">
            <?php echo form_error('full_name','<span class="help-block">','</span>'); ?>
            <br>
        </div>
        <div class="email">
            <b>Email: </b>
        </div>
        <div class="email_input">
            <input type="text" name="email" placeholder="example@example.com">
            <?php echo form_error('email','<span class="help-block">','</span>'); ?>
            <br>
        </div>
        <div class="phone">
            <b>Phone nr: </b>
        </div>
        <div class="phone_input">
            <input type="tel" name="phone" placeholder="phonenumber">
            <?php echo form_error('phone','<span class="help-block">','</span>'); ?>
        </div>

        //copied from account:
        <div class="buttons">
            <input type="submit" value="Save changes" name="saveSettings"/>
            <input type="button" value="Cancel" onclick="location.href='newResident'"/>
        </div>
        //

    </div>

</form>
</body>
</html>