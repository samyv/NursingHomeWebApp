<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proficiat</title>
    <link href="<?=base_url()?>assets/css/finalpage.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="grid-container">
    <div id="name">Grace Age</div><br>

    <div id="praise">Proficiat {resident}!<br>
        Je hebt alle vragen beantwoord!<br>
        Dankjewel voor  je tijd. Op deze manier kunnen we de zorg verbeteren</div>

    <div id="note">Klik op de knop om terug te gaan</div>


    <div id="home_btn">
        <button id="home" onclick="location.href='<?=base_url();?>resident'">Home</button>
    </div>

    <div id="previous_btn">
        <button id="previous" onclick="location.href = '<?=base_url();?>resident/questionpage/<?= $index?>'">Vorige</button>
    </div>
</div>

</body>
</html>