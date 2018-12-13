<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Page</title>
    <link href="<?=base_url()?>assets/css/noticepage.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="grid-container">


    <div id="name">Grace Age</div><br>

    <div id="praise">
        You already answered all the questions!<br>
        Come back tomorrow.<br>
        Thank you!
    </div>

    <div id="note">Press the button below to go to the home screen.</div>


    <div id="home_btn">
        <button id="home" onclick="location.href='index'">Home</button>
    </div>

    <div id="previous_btn">
        <button id="previous" onclick="location.href = '<?=base_url();?>resident/tutorialpage'">Previous</button>
    </div>
    <div id="footer">
        <footer>
            <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
            </p>
        </footer>
    </div>
</div>

</body>
</html>