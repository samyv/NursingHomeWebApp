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

<p id="question">{question}</p>
<div id = hidden>
<p id="nextType">{nextType}</p>
<p id="currentType">{currentType}</p>
</div>
<div id="answers">
    <input type="radio" id="answer1" name="answer" value="1" class = 'question_radio'/>
    <label for="answer1">Answer1</label>

    <input type="radio" id="answer2" name="answer" value="2" class = 'question_radio'/>
    <label for="answer2">Answer2</label>

    <input type="radio" id="answer3" name="answer" value="3" class = 'question_radio'/>
    <label for="answer3">Answer3</label>

    <input type="radio" id="answer4" name="answer" value="4" class = 'question_radio'/>
    <label for="answer4">Answer4</label>

    <input type="radio" id="answer5" name="answer" value="5" class = 'question_radio'/>
    <label for="answer5">Answer5</label>
</div>

<button id="previous">Previous</button>


<script>
    // var nextType = document.getElementById("nextType");
    // var currentType = document.getElementById("currentType");
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms))
    }

    $(document).ready(function(){
        var index = 1;
        var awaitTime = 200;
        var maxQuestionNr = 50;
        var nextType;
        var currentType;

        $.ajax({
            url:'<?php echo site_url('index.php/Resident/getIndex');?>',
            method:"POST",
            success:function(i)
            {
                if( i == null)
                {index = 1;}else{
                    index = i;
                }
            }
        });

        function transQuestionTextAndAns($index, $answer){
            $.ajax({
                url:'<?php echo site_url('index.php/Resident/update');?>',
                method:"POST",
                data:{index:$index,
                    answer:$answer,
                    },
                success:function(question)
                {
                    $('#question').html(question);
                }
            });
        }

        function transOldAnswer($index){
            $.ajax({
                url:'<?php echo site_url('index.php/Resident/getOldAnswer');?>',
                method:"POST",
                data:{index:$index},
                success:function(answer)
                {
                    $('#answer'+answer).prop('checked',true);
                }
            });
        }

        function checkIfLastQuestion($index){
            $.ajax({
                url:'<?php echo site_url('index.php/Resident/getNextQuestionType');?>',
                method:"POST",
                data:{index:$index},
                success:function(i)
                {
                    $('#nextType').html(i);
                    nextType = i;
                }
            });
            $.ajax({
                url:'<?php echo site_url('index.php/Resident/getCurrentQuestionType');?>',
                method:"POST",
                data:{index:$index},
                success:function(i)
                {
                    $('#currentType').html(i);
                    currentType = i;
                }
            });
            // return currentType !== nextType;
        }

        // transOldAnswer(index);

        $('#answer1').click(async function(){
            if(index < maxQuestionNr) {
                index++;
                await sleep(awaitTime);
                checkIfLastQuestion(index)
                if(currentType !== nextType){
                    console.log("current: "+currentType);
                    console.log("next: "+nextType);
                // if(true){
                    window.location.pathname='a18ux02/resident/section/'+nextType
                } else {
                    transQuestionTextAndAns(index, 1);
                }
                // transOldAnswer(index);
                $(this).prop('checked', false);
            }
        });

        $('#answer2').click(async function(){
            if(index < maxQuestionNr) index++;
            await sleep(awaitTime);
            transQuestionTextAndAns(index,2);
            // transOldAnswer(index);
            $(this).prop('checked', false);
        });

        $('#answer3').click(async function(){
            if(index < maxQuestionNr) index++;
            await sleep(awaitTime);
            transQuestionTextAndAns(index,3);
            // transOldAnswer(index);
            $(this).prop('checked', false);
        });

        $('#answer4').click(async function(){
            if(index < maxQuestionNr) index++;
            await sleep(awaitTime);
            transQuestionTextAndAns(index,4);
            // transOldAnswer(index);
            $(this).prop('checked', false);
        });

        $('#answer5').click(async function() {
            if(index < maxQuestionNr) index++;
            await sleep(awaitTime);
            transQuestionTextAndAns(index,5);
            // transOldAnswer(index);
            $(this).prop('checked', false);
        });
        $('#previous').click(async function(){
            if(index > 1) index--;
            transQuestionTextAndAns(index,null);
            // transOldAnswer(index);
        });
    });
</script>
<footer>
    <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
    </p>
</footer>
</body>
</html>