<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question</title>
    <link href="<?=base_url()?>assets/css/questionPage.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>



<div id="firstRow">
    <h1 id="dummy"></h1>
    <h1 id="logo">GraceAge</h1>
    <button type="submit">Log out</button>
</div>

<p id="questionType">Question Type(2/5)</p>

<div class="progress" id="progressbar">
    <div class="progress-bar progress-bar-striped active" role="progressbar"
         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
        40%
    </div>
</div>

<p id="question">You can write you question here.</p>


<div id="answers">
    <input type="radio" id="answer1" name="answer" value="1"/>
    <label for="answer1">Answer1</label>

    <input type="radio" id="answer2" name="answer" value="2"/>
    <label for="answer2">Answer2</label>

    <input type="radio" id="answer3" name="answer" value="3"/>
    <label for="answer3">Answer3</label>

    <input type="radio" id="answer4" name="answer" value="4"/>
    <label for="answer4">Answer4</label>

    <input type="radio" id="answer5" name="answer" value="5"/>
    <label for="answer5">Answer5</label>
</div>

<button id="previous">Change Last Answer</button>

<footer>
    <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
    </p>
</footer>
</body>
</html>