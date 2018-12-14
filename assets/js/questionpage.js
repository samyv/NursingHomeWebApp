function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
}

function transOldAnswer(index) {
    $.ajax({
        url: '../getOldAnswer',
        method: "POST",
        data: {index: index},
        success: function (answer) {
            $('#answer' + answer).prop('checked', true);
        }
    });
}

function updateNewAns($index, $answer) {
    $.ajax({
        url: '../update',
        method: "POST",
        data: {
            index: $index,
            answer: $answer,
        }
    });
}

function getParameters(index, callback){
    $.ajax({
        async: false,
        url: '../getparameters/'+index,
        method: "POST",
        dataType: "JSON",
        data: {},
        success: function (response) {
            callback(response);
        }
    });
}


$(document).ready(function () {
    let awaitTime = 50;
    let index = document.getElementById("index").innerText;



    let currentType = 0;
    let nextType = 0;
    let previousQuestion = 0;
    let nextQuestion = 0;

    getParameters(index, function (data) {
        currentType = data.currentType;
        nextType = data.nextType;
        previousQuestion = data.previousQuestion;
        nextQuestion = data.nextQuestion;
    });


    transOldAnswer(index);

    $('#answer1').click(async function(){
        updateNewAns(index,1);
        if(nextQuestion != -1) {
            await sleep(awaitTime);
            if(currentType != nextType){
                index = nextQuestion;
                window.location.href='../section/'+nextType+'/'+index;
            } else {
                index = nextQuestion;
                window.location.href=''+index;
            }
        } else {
            window.location.href = '../finalpage';
        }
    });

    $('#answer2').click(async function(){
        updateNewAns(index,2);
        if(nextQuestion != -1) {
            await sleep(awaitTime);
            if(currentType != nextType){
                index = nextQuestion;
                window.location.href='../section/'+nextType+'/'+index;
            } else {
                index = nextQuestion;
                window.location.href=''+index;
            }
        } else {
            window.location.href = '../finalpage';
        }
    });

    $('#answer3').click(async function(){
        updateNewAns(index,3);
        if(nextQuestion != -1) {
            await sleep(awaitTime);
            if(currentType != nextType){
                index = nextQuestion;
                window.location.href='../section/'+nextType+'/'+index;
            } else {
                index = nextQuestion;
                window.location.href=''+index;
            }
        } else {
            window.location.href = '../finalpage';
        }
    });

    $('#answer4').click(async function(){
        updateNewAns(index,4);
        if(nextQuestion != -1) {
            await sleep(awaitTime);
            if(currentType != nextType){
                index = nextQuestion;
                window.location.href='../section/'+nextType+'/'+index;
            } else {
                index = nextQuestion;
                window.location.href=''+index;
            }
        } else {
            window.location.href = '../finalpage';
        }
    });

    $('#answer5').click(async function(){
        updateNewAns(index,5);
        if(nextQuestion != -1) {
            await sleep(awaitTime);
            if(currentType != nextType){
                index = nextQuestion;
                window.location.href='../section/'+nextType+'/'+index;
            } else {
                index = nextQuestion;
                window.location.href=''+index;
            }
        } else {
            window.location.href = '../finalpage';
        }
    });

    $('#previous').click(async function(){
        if(index > 1) {
            index=previousQuestion;
            window.location.href = ''+index;
        } else {
            window.location.href = '../tutorialpage'
        }
    });

});