<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/tutorialpage.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <title>{page_title}</title>
</head>

<body>
<div class="grid-container">
    <div class="header">
        <h1>GraceAge</h1>
        <a type="button" href="<?php echo base_url();?>Resident/logout">log out</a>
    </div>


        <h1>Welcome <?php
                echo $_SESSION['Resident']['firstname'];
                ?>
        </h1>
    <div class="container">
        <p>Take a look at the tutorial video. This will show you how to use this application</p>
        <p>If you're ready or want to skip this video, press the start button to begin!</p>
        <video>here comes a video</video>
    </div>
    <div class="startbtn">
        <input type="button" value="Start" onclick="location.href=<?php echo base_url();?>Resident/page">
    </div>

</div>
</body>
</html>
