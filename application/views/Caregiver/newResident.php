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
    <div class="grid-container">
        <div class = "resident">
            <h3>Resident information</h3>
        </div>

        <div class="firstname">
            <b>First name: </b>
        </div>
        <div class="firstname_input">
            <input type="text" placeholder="Enter first name" class = "form-control" name="firstname" required=""
                   value="<?php echo !empty($resident['firstname'])?$resident['firstname']:''; ?>">
            <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
        </div>
        <div class="lastname">
            <b>Last name: </b>
            <br>
        </div>
        <div class="lastname_input">
            <input type="text" placeholder="Enter last name" class = "form-control" name="lastname" required=""
                   value="<?php echo !empty($resident['lastname'])?$resident['lastname']:''; ?>">
            <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
        </div>
        <div class="birthday">
            <b>Birthday: </b>
            <br>
        </div>
        <div class="birthday_input">
            <input type="date" placeholder="" name="birthdate" class = "form-control" required="">
            <?php echo form_error('birthdate','<span class="help-block">','</span>'); ?>
        </div>
        <div class="gender">
            <b>Gender: </b>
            <br>
        </div>
        <div class="gender_input" name="gender"  required="">
            <select name="gender" class = "form-control">
                <option value="male">male</option>
                <option value="female">female</option>
            </select>
            <?php echo form_error('gender','<span class="help-block">','</span>'); ?>
        </div>
        <div class="floor">
            <b>Floor: </b>
            <br>
        </div>
        <div class="floor_input">
            <input type="number" name="floor" class = "form-control" placeholder="Enter floor number" min="0" required="">
            <?php echo form_error('floor','<span class="help-block">','</span>'); ?>
        </div>
        <div class="room">
            <b>Room: </b>
            <br>
        </div>
        <div class="room_input">
            <input type="number" name="room" class = "form-control" placeholder="Enter room number" min="1"required="">
            <?php echo form_error('room','<span class="help-block">','</span>'); ?>
        </div>

        <div class = "extra">
            <h3>Contact information</h3>
        </div>

        <div class="contact_first">
            <b>First name: </b>
        </div>
        <div class="contact_first_input">
            <input type="text" name="first_name"  class = "form-control" placeholder="Enter first name" required="">
            <br>
        </div>
        <div class="contact_last">
            <b>Last name: </b>
        </div>
        <div class="contact_last_input">
            <input type="text" name="last_name"  class = "form-control" placeholder="Enter last name" required="">
            <br>

        </div>
        <div class="email">
            <b>Email: </b>
        </div>
        <div class="email_input">
            <input type="text" name="email" class = "form-control" placeholder="Enter email">
            <br>
        </div>
        <div class="phone">
            <b>Phone nr: </b>
        </div>
        <div class="phone_input">
            <input type="tel" name="phone" class = "form-control" placeholder="Enter phone number">
        </div>
        <div class="relation">
            <b>Relation: </b>
        </div>

        <div class="relation_input">
            <select name="relation" onchange='checkChoice(this.value);' class="form-control">
                <option>Relation to resident</option>
                <option value="son">son</option>
                <option value="daughter">daughter</option>
                <option value="brother">brother</option>
                <option value="sister">sister</option>
                <option value="other">other</option>
            </select>
            <input type="text" name="relation" id="relation" style='display:none;' class="form-control" placeholder="Enter your relation"/>

        </div>
        <div class="buttons">
            <input type="submit" value="Add resident" name="saveSettings"/>
            <input type="button" value="Cancel" onclick="location.href='landingPage'"/>
        </div>
        </div>
</form>
<script type="text/javascript">
    function checkChoice(val){
        var element=document.getElementById('relation');
        if(val=='Choose your relation'||val=='other')
            element.style.display='block';
        else
            element.style.display='none';
    }

</script>
</body>
</html>
