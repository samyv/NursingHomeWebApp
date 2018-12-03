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

<div class="grid-container">
    <h1 id="logo">GraceAge</h1>
    <button id="logout" type="submit" onclick="location.href='<?=base_url();?>Resident'">Log out</button>

<p id="questionType">Question Type({currentNum}/{totalNum})</p>

<div class="progress" id="progressbar">
    <div class="progress-bar progress-bar-striped active" role="progressbar"
         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:{percentage}">
        {percentage}
    </div>
</div>

    <div id="question">{question}</div>

    <div id="answers">
        <input type="radio" id="answer1" name="answer" value="1" class = 'question_radio'/>
        <label for="answer1" id="answer_1">Answer1</label>

        <input type="radio" id="answer2" name="answer" value="2" class = 'question_radio'/>
        <label for="answer2" id="answer_2">Answer2</label>

        <input type="radio" id="answer3" name="answer" value="3" class = 'question_radio'/>
        <label for="answer3" id="answer_3">Answer3</label>

        <input type="radio" id="answer4" name="answer" value="4" class = 'question_radio'/>
        <label for="answer4" id="answer_4">Answer4</label>

        <input type="radio" id="answer5" name="answer" value="5" class = 'question_radio'/>
        <label for="answer5" id="answer_5">Answer5</label>
    </div>

    <button id="previous">Previous</button>
</div>


<script>
    // var nextType = document.getElementById("nextType");
    // var currentType = document.getElementById("currentType");
    // var currentNum = document.getElementById("currentNum");
    // var totalNum = document.getElementById("totalNum");
    // var percentage = document.getElementById("percentage");
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms))
    }

    $(document).ready(function(){
        var awaitTime = 200;
        var maxQuestionNr = 50;
        var nextType;
        var currentType;
        var currentNum=1;
        var totalNum;
        var index = <?= $index?>;


        function transOldAnswer() {
            $.ajax({
                url: '<?=base_url();?>Resident/getOldAnswer',
                method: "POST",
                data: {index: index},
                success: function(answer) {
                    $('#answer' + answer).prop('checked', true);
                }
            });
        }

        transOldAnswer();

        function updateNewAns($index, $answer){
            $.ajax({
                url:'<?=base_url();?>Resident/update',
                method:"POST",
                data:{index:$index,
                    answer:$answer,
                    },
                success:function()
                {
                    alert("nice");
                }
            });
        }

        function getTotalNum($index){
            $.ajax({
                url:'<?=base_url();?>Resident/getTotalNum',
                method:"POST",
                data:{index:$index},
                success:function(i)
                {
                    totalNum = i;
                }
            });
            currentNum++;
            if(currentNum>totalNum){
                currentNum = 1;
            }

            // return currentType !== nextType;
        }

        function checkIfLastQuestion($index){
            $.ajax({
                url:'<?=base_url();?>Resident/getNextQuestionType',
                method:"POST",
                data:{index:$index},
                success:function(i)
                {
                    nextType = i;
                }
            });
            $.ajax({
                url:'<?=base_url();?>Resident/getCurrentQuestionType',
                method:"POST",
                data:{index:$index},
                success:function(i)
                {
                    currentType = i;
                }
            });
        }


        $('#answer1').click(async function(){
            updateNewAns(index,1);
            if(index+1 < maxQuestionNr) {
                await sleep(awaitTime);
                checkIfLastQuestion(index);
                if(currentType !== nextType){
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/0';
                } else {
                    getTotalNum(index);
                    index++;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            }
        });

        $('#answer2').click(async function(){
            updateNewAns(index,2);
            if(index+1 < maxQuestionNr) {
                await sleep(awaitTime);
                checkIfLastQuestion(index);
                if(currentType !== nextType){
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/0';
                } else {
                    getTotalNum(index);
                    index++;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            }
        });

        $('#answer3').click(async function(){
            updateNewAns(index,3);
            if(index+1 < maxQuestionNr) {
                await sleep(awaitTime);
                checkIfLastQuestion(index);
                if(currentType !== nextType){
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/0';
                } else {
                    getTotalNum(index);
                    index++;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            }
        });

        $('#answer4').click(async function(){
            updateNewAns(index,4);
            if(index+1 < maxQuestionNr) {
                await sleep(awaitTime);
                checkIfLastQuestion(index);
                if(currentType !== nextType){
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/0';
                } else {
                    getTotalNum(index);
                    index++;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            }
        });

        $('#answer5').click(async function() {
            updateNewAns(index,5);
            if(index+1 < maxQuestionNr) {
                await sleep(awaitTime);
                checkIfLastQuestion(index);
                if(currentType !== nextType){
                    window.location.href='<?=base_url();?>resident/section/'+nextType+'/0';
                } else {
                    getTotalNum(index);
                    index++;
                    window.location.href='<?=base_url();?>resident/questionpage/'+index;
                }
            }
        });

        $('#previous').click(async function(){
            if(index > 1) index--;
            window.location.href = '<?=base_url();?>resident/questionpage/'+index;
        });
    });
</script>
<footer>
    <p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
    </p>
</footer>
</body>
</html>