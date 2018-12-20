<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Question</title>
    <link href="<?= base_url() ?>assets/css/questionPage.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.responsivevoice.org/1.5.7/responsivevoice.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<div class="grid-container">
    <div id="header">
        <div id="title">GraceAge</div>
        <div id="logout">
			<button id="logoutbtn" type="submit" onclick="location.href='<?= base_url(); ?>Resident'">Log out</button>
			<button id="musicbtn" onclick=toggleAudio()>Speel geluid af</button>
			</div>
    </div>

    <div id="questionType">{sectionType} ({currentNum}/{totalNum})</div>

    <div class="progress" id="progressbar">
        <div class="progress-bar progress-bar-striped active" role="progressbar"
             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:{percentage}">
            {percentage}
        </div>
    </div>

    <div id="index">{index}</div>

    <div id="question">{question}</div>

    <div id="answers">
        <div>
            <input type="radio" id="answer1" name="answer" value="1" class='question_radio'/>
            <label for="answer1" id="answer_1">Nooit</label>
        </div>
        <div>
            <input type="radio" id="answer2" name="answer" value="2" class='question_radio'/>
            <label for="answer2" id="answer_2">Zelden</label>
        </div>
        <div>
            <input type="radio" id="answer3" name="answer" value="3" class='question_radio'/>
            <label for="answer3" id="answer_3">Soms</label>
        </div>
        <div>
            <input type="radio" id="answer4" name="answer" value="4" class='question_radio'/>
            <label for="answer4" id="answer_4">Meestal</label>
        </div>
        <div>
            <input type="radio" id="answer5" name="answer" value="5" class='question_radio'/>
            <label for="answer5" id="answer_5">Altijd</label>
        </div>
    </div>
    <div id="previous">
        <button id="previousbtn">Vorige</button>
    </div>
    </div>
</div>

<script>
	$(document).ready(function () {
		$('.autoB').click();
		// responsiveVoice.speak(question);

	});
	function toggleAudio()
	{
		var string = '{question}';
		responsiveVoice.speak(string, "Dutch Female")
	}



</script>
<script src="<?=base_url();?>assets/js/questionpage.js"></script>

</body>
</html>
