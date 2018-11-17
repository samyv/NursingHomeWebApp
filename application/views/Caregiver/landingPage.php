<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/landingPage.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <title>Home | GraceAge</title>
</head>
<body>
<div class="grid-container">

    <div class = "title">
        <h1>Welcome back <?php echo  $_SESSION['firstname']; ?>!</h1>
    </div>

    <div class = "quote">
        <h5 id="quote">
			<?php
			$number = rand(1,1000);
			$this->load->model('caregivers');
			echo $this->caregivers->getQuote($number);
			?>
		</h5>
    </div>
    <div class="btn-group-vertical">
        <div class="btn-group">
            <input value="Search a resident" type="button" class = "btn" onclick="location.href='residents'">
            <input value="Floor comparison" type="button" class = "btn" onclick="location.href='floorCompare'">
        </div>
        <div class="btn-group">
            <input value="Floor Select" type="button" class = "btn" onclick="location.href='floorSelect'">
            <input value="Action center" type="button" class = "btn" onclick="location.href='actionCenter'">
        </div>
    </div>




</div>
</body>
</html>
