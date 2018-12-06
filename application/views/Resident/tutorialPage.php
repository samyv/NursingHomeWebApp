<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutorial</title>
    <link href="<?=base_url();?>assets/css/tutorialpage.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="grid-container">

    <div id="names">
        <div id="name">Grace Age</div><br>
        <div id="subname">Providing better care</div>
    </div>

    <div id="note">Watch the tutorial video below to see how to log in</div>

    <div id="video">
        <video src="<?=base_url();?>assets/videos/tutorial.mp4" controls="controls" autoplay="autoplay">The browser does not support the video.</video>
    </div>


    <div id="btn">
        <button id="startQuestionnaire" onclick="location.href='<?=base_url();?>Resident/startQuestionnaire'">Skip tutorial</button>
    </div>
</div>

<script>

</script>


</body>
</html>
