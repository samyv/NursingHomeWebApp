<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Proficiat</title>
    <link href="<?=base_url()?>assets/css/finalpage.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="grid-container">
    <div id="name"></div><br>

    <div id="praise">Proficiat {resident}!<br>
        Je hebt alle vragen beantwoord!<br>
        Dankjewel voor  je tijd. Op deze manier kunnen we de zorg verbeteren</div>

    <div id="note">Klik op de knop om terug te gaan</div>


    <div id="home">
        <button id="home_btn" onclick="location.href='<?=base_url();?>resident'">Home</button>
    </div>

    <div id="previous">
        <button id="previous_btn" onclick="location.href = '<?=base_url();?>resident/questionpage/<?= $index?>'">Vorige</button>
    </div>
</div>

</body>
</html>