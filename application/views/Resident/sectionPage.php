<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section</title>
    <link href="<?= base_url() ?>assets/css/sectionPage.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="grid-container">
    <div id="header">
        <div id="title">GraceAge</div>
        <div id="logout">
            <button id="logoutbtn" type="submit" onclick="location.href='<?=base_url();?>Resident'">Log out</button>
        </div>
    </div>

    <div id="subtitle">
        <?php
        if ($sectionID == 1) {
            echo "Laten we beginnen!";
        } else {
            echo "Goed gedaan!";
        }
        ?></div>

    <div id="description">
        <?= $sectionDescription ?>
    </div>
    <div id="img">
        <img id="logoImg" src="http://localhost/a18ux02/assets/images/<?= $image ?>">
    </div>
    <div id="continue">
        <button id="continuebtn" onclick="location.href='<?= base_url(); ?>resident/questionpage/<?= $index ?>'">Continue
        </button>
    </div>


</div>

</body>
