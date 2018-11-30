<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section</title>
    <link href="<?=base_url()?>assets/css/sectionPage.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="grid-container">

    <h1 id="logo">GraceAge</h1>

    <button id="logout" type="submit">Log out</button>

    <h1 id="title">Let's Start! or Good Job!</h1>

    <p id="description">{sectionDescription}</p>

    <img id="logoImg" src="http://localhost/a18ux02/assets/images/{image}">

    <button id="continue" onclick="location.href='<?php echo base_url()?>resident/questionpage/{index}'">Continue</button>

</div>

</body>
