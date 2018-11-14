<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/tutorialpage.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <title>{page_title}</title>
</head>

<body class="grid-container">
    <div class="header">
        <h1>GraceAge</h1>
        <a type="button" href="<?php echo base_url();?>Resident/logout">log out</a>
    </div>

        <h1>Welcome <?php
            if(isset($_SESSION['Resident0'])){
                echo $_SESSION['Resident0']['firstname'];
            }
            if(isset($_SESSION['Resident1'])){
                echo $_SESSION['Resident1']['firstname'];
            }?>
        </h1>
   <div class="explain">
        <p>Take a look at the tutorial video. This will show you how to use this application</p>
        <p>If you're ready or want to skip this video, press the start button to begin!</p>
   </div>
	<div class="video">
        <video>here comes a video</video>
<!--		<p>HERE COMES THE VIDEO</p>-->
    </div>
    <div class="startbtn">
        <input type="button" value="Start">
    </div>

</body>
</html>
