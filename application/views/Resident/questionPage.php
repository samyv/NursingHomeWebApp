<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question</title>
    <link href="<?= base_url() ?>assets/css/questionPage.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="grid-container">
    <div id="header">
        <div id="title">GraceAge</div>
        <div id="logout">
            <button id="logoutbtn" type="submit" onclick="location.href='<?= base_url(); ?>Resident'">Log out</button>
        </div>
    </div>

    <div id="questionType">{sectionType} ({currentNum}/{totalNum})</div>

    <div class="progress" id="progressbar">
        <div class="progress-bar progress-bar-striped active" role="progressbar"
             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:{percentage}">
            {percentage}
        </div>
    </div>

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
        <button id="previousbtn">Previous</button>
    </div>
    <div id="footer">
        <footer>
            <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
            </p>
        </footer>
    </div>
</div>


<script>
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms))
    }

    $(document).ready(function () {
        let awaitTime = 200;
        let index = <?= $index?>;
        let currentType = <?= $currentType?>;
        let nextType = <?= $nextType?>;
        let previousQuestion = <?= $previousQuestion?>;
        let nextQuestion = <?= $nextQuestion?>;


        function transOldAnswer() {
            $.ajax({
                url: '<?=base_url();?>Resident/getOldAnswer',
                method: "POST",
                data: {index: index},
                success: function (answer) {
                    $('#answer' + answer).prop('checked', true);
                }
            });
        }

        transOldAnswer();

        function updateNewAns($index, $answer) {
            $.ajax({
                url: '<?=base_url();?>Resident/update',
                method: "POST",
                data: {
                    index: $index,
                    answer: $answer,
                }
            });
        }


        $('#answer1').click(async function(){
            updateNewAns(index,1);
            if(nextQuestion != -1) {
                await sleep(awaitTime);
                if(currentType != nextType){
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/'+index;
                } else {
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            } else {
                window.location.href = '<?=base_url();?>resident/finalpage';
            }
        });

        $('#answer2').click(async function(){
            updateNewAns(index,2);
            if(nextQuestion != -1) {
                await sleep(awaitTime);
                if(currentType != nextType){
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/'+index;
                } else {
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            } else {
                window.location.href = '<?=base_url();?>resident/finalpage';
            }
        });

        $('#answer3').click(async function(){
            updateNewAns(index,3);
            if(nextQuestion != -1) {
                await sleep(awaitTime);
                if(currentType != nextType){
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/'+index;
                } else {
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            } else {
                window.location.href = '<?=base_url();?>resident/finalpage';
            }
        });

        $('#answer4').click(async function(){
            updateNewAns(index,4);
            if(nextQuestion != -1) {
                await sleep(awaitTime);
                if(currentType != nextType){
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/'+index;
                } else {
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            } else {
                window.location.href = '<?=base_url();?>resident/finalpage';
            }
        });

        $('#answer5').click(async function() {
            updateNewAns(index,5);
            if(nextQuestion != -1) {
                await sleep(awaitTime);
                if(currentType != nextType){
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/'+index;
                } else {
                    index = nextQuestion;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            } else {
                window.location.href = '<?=base_url();?>resident/finalpage';
            }
        });

        $('#previous').click(async function(){
            if(index > 1) {
                index=previousQuestion;
                window.location.href = '<?=base_url();?>resident/questionpage/'+index;
            } else {
                window.location.href = '<?=base_url();?>resident/tutorialpage'
            }

        });
    });
</script>

</body>
</html>