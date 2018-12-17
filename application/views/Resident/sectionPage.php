<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Section</title>
    <link href="<?= base_url() ?>assets/css/sectionPage.css" type="text/css" rel="stylesheet">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://code.responsivevoice.org/1.4/responsivevoice.js"></script>
<div class="grid-container">
    <div id="header">
        <div id="title">GraceAge</div>
        <div id="logout">
            <button id="logoutbtn" type="submit" onclick="location.href='<?=base_url();?>Resident'">Log out</button>
        </div>
    </div>

    <div id="subtitle">
        <?php
		$string = "";
		$start = "Laten we beginnen!";
		$end = "Goed gedaan!";
        if ($sectionID == 1) {
            echo $start;
            $string.= $start;
        } else {
            echo $end;
            $string.=$end;
        }
        ?></div>

    <div id="description">
        <?= $sectionDescription ?>
    </div>
    <div id="img">
        <img id="logoImg" src="http://localhost/a18ux02/assets/images/<?= $image ?>">
    </div>
    <div id="continue">
        <button id="continuebtn" onclick="location.href='<?= base_url(); ?>resident/questionpage/<?= $index ?>'">Volgende
        </button>
    </div>


</div>
<script>
	$(document).ready(function () {

		// responsiveVoice.speak(question);
		var string = '<?php echo $string.$sectionDescription;?>'
		responsiveVoice.speak(string, "Dutch Female");
	});

</script>
</body>
