<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Handleiding</title>
    <link href="<?=base_url();?>assets/css/tutorialpage.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="grid-container">

    <div id="video">
        <video src="<?=base_url();?>assets/videos/tutorial.mp4" controls="controls" autoplay="autoplay">The browser does not support the video.</video>
    </div>


    <div id="btn">
        <button id="startQuestionnaire" onclick="location.href='<?=base_url();?>Resident/startQuestionnaire'">Start vragenlijst</button>
    </div>
</div>
</body>
</html>
