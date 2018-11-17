<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/landingPage.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <title>{page_title}</title>
</head>
<body>
<div class="grid-container">

    <div class = "title">
        <h1>Welcome back <?php echo 'Julie' /*$caregiver['firstname'], " ", $caregiver['lastname']*/ ; ?>!</h1>
    </div>

    <div class = "quote">
        <h3 id="quote">
			<?php
			$number = rand(1,1000);
			$this->load->model('caregivers');
			echo $this->caregivers->getQuote($number);
			?>
		</h3>
    </div>

    <div class = "button1">
        <input type="button" value="Go to residents list view" onclick="location.href='residents'"/>
    </div>
    <div class = "button2">
        <input type="button" value="Go to floor comparison" onclick="location.href='floorComparison'"/>
    </div>

    <div class = "button3">
        <input type="button" value="Go to floor selection" onclick="location.href='floorView'"/>
    </div>



</div>
</body>
</html>
