<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/loginResident.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
<!--    <script src="--><?//=base_url()?><!--assets/js/Resident/login.js"></script>-->
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="grid-container">
     <div class="logo">
<!--        <h1 id="tile">GraceAge</h1>-->
<!--        <h2 id="subtitle">Providing better care</h2>-->
         <div id="title">GraceAge</div><br>
         <div id="subtitle">Providing better care</div>
     </div>

<!-- form to submit the room number -->
     <div class="form">
        <form action="" method="POST">
            <div class="form-group">
                <label for="roomField" id = "roomNum"><b>Room number </b></label>
                <input class=inputController type="number" min="0" placeholder="Enter room number" name="room_number" required="">
                <?php echo form_error('room_number','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
                <input id="loginButton" name="loginResident" type="submit" value="Login">
            </div>
        </form>
     </div>
      <!--create buttons for each resident in the room, the form is so you can parse the right data to the session-->
      <div class="ResidentButton">
      <?php
      $i = 1;
      if($residentNames){
      foreach ($residentNames as $resident){?>
          <div>

          <form method="post">

              <button type="submit" name="selectResident<?php echo $i?>" class="ResidentButton" value="<?php echo $resident['firstname'], " ", $resident['lastname'] ?>">

                  <?php if(isset($resident['picture'])){ ?>
                      <img type="submit" src="data:image/jpg;base64, <?php echo base64_encode($resident['picture']);?>"/>
                  <?php }?>
              <p><?php echo $resident['firstname'], " ", $resident['lastname'] ?></p></button>
          </form>
          </div>
          <?php $i++;
      }}else if(isset($error_msg)){?>
              <p id="error"><?php echo $error_msg ?></p>
          <?php
      }?>
      </div>

     <div id="footer">
          <footer>
              <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
              </p>
          </footer>
     </div>
</div>




</body>
</html>
