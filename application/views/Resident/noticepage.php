<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Final Page</title>
    <link href="<?=base_url()?>assets/css/noticepage.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="grid-container">


    <div id="name">Grace Age</div><br>

    <div id="praise">
        Je hebt de vragen al beantwoord!<br>
        Kom morgen terug.<br>
        Dankjewel!
    </div>

    <div id="note">Druk op de knop beneden om terug te keren.</div>


    <div id="home_btn">
        <button id="home" onclick="location.href='<?=base_url();?>resident'">Startscherm</button>
    </div>

    <div id="previous_btn">
        <button id="previous" onclick="location.href = '<?=base_url();?>resident/tutorial'">Vorige</button>
    </div>
    </div>
</div>

</body>
</html>