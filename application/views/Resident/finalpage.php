<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Page</title>
    <link href="<?=base_url()?>assets/css/finalpage.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="grid-container">


    <div id="name">Grace Age</div><br>

    <div id="praise">Congratulations {resident}!<br>
        You answered all the questions!<br>
        We thank you very much for your time so we can improve our care for you.</div>

    <div id="note">Press the button below to go to the home screen.</div>


    <div id="home_btn">
        <button id="home" onclick="location.href='index'">Home</button>
    </div>

    <div id="previous_btn">
        <button id="previous" onclick="location.href = '<?=base_url();?>resident/questionpage/<?= $index?>'">Previous</button>
    </div>
</div>


</body>
</html>