<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/newQuestion.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>{page_title}</title>
</head>

<body>
    <div class="grid-container">
		<div class="sectionTable">
			<table id="sTable">
				<thead>
				<th>#</th>
				<th>Section</th>
				<th>
					<button id="addSection">+</button>
				</th>
				</thead>
			</table>
		</div>
		<div class="questionTable">
			<table id="qTable">
				<thead>
				<th>#</th>
				<th>Question</th>
				<th>
					<button id="addQuestion">+</button>
				</th>
				</thead>
			</table>
		</div>
		<div class="save">
			<button id="save">SAVE</button>
		</div>
	</div>
<script type="text/javascript">
	let lastSectionClicked = 1;
	$(function () {
		populateSections();
		init();
		lastSectionClicked = 1;

		$('#addQuestion').on('click',function () {
			var table = document.getElementById("qTable");
			var tbody = table.children[1];
			let amountOfQuestions = tbody.children.length;
// Create an empty <tr> element and add it to the 1st position of the table:
			var row = table.insertRow(amountOfQuestions+1);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);

// Add some text to the new cells:
			cell1.innerHTML = amountOfQuestions+1;
			cell2.innerHTML = "New Question";
			cell2.setAttribute("contenteditable",'true');
			let saveQBut = $('<button/>',
				{
					text: 'save',
					id: "saveQuestion",
					click: function () {
						if(this.innerHTML == "save") {
							//FIND VALUES FOR NEW QUESTION
							var lastQuestionTotal = questionsDB.slice(-1)[0];
							console.log(lastQuestionTotal)
							var lastID = parseInt(lastQuestionTotal.idQuestion);
							//PK
							let newQID = lastID + 1;
							//FIND PosNum AND nextQuestion with lastQuestion of the same section
							var lastQuestionSection = questionsDB.filter(e => e.questionType == lastSectionClicked).slice(-1)[0]
							let newPosNum = parseInt(lastQuestionSection.positionNum) + 1;
							let firstQOfNextSID = lastQuestionSection.nextQuestionId;
							var newQuestion = {
								idQuestion: newQID.toString(),
								questionText: this.parentElement.parentElement.children[1].innerText,
								nextQuestionId: firstQOfNextSID.toString(),
								previousQuestionId: lastQuestionSection.idQuestion.toString(),
								positionNum: newPosNum.toString(),
								questionType: lastSectionClicked.toString()
							}
							lastQuestionSection.nextQuestionId = (lastID + 1).toString();

							var firstQOfNextS = questionsDB.filter(e => e.idQuestion == firstQOfNextSID).slice(-1)[0]
							firstQOfNextS.previousQuestionId = (lastID + 1).toString();
							questionsDB.push(newQuestion)
							this.innerHTML = "delete";
						} else {
							var questionToErase = questionsDB.filter(e => e.questionType == lastSectionClicked && e.positionNum == this.parentElement.parentElement.children[0].innerText).slice(-1)[0]
							var nextQuestionID = questionToErase.nextQuestionId;
							var prevQuestionID = questionToErase.previousQuestionId;
							var prevQuestion = questionsDB.filter(e => e.idQuestion == prevQuestionID).slice(-1)[0]
							var nextQuestion = questionsDB.filter(e => e.idQuestion == nextQuestionID).slice(-1)[0]
							prevQuestion.nextQuestionId = nextQuestionID.toString();
							nextQuestion.previousQuestionId = prevQuestionID.toString();
							var key = null;
							for (var prop in questionsDB)
							{
								if (questionsDB.hasOwnProperty(prop))
								{
									if (questionsDB[prop] === questionToErase)
									{
										key = prop;
									}
								}
							}
							delete questionsDB.key
							clean(questionsDB)
							console.log(questionsDB)
							let tbody = this.parentElement.parentElement.parentElement;
							let amountOfQuestions = tbody.children.length;
							this.parentElement.parentElement.parentElement.parentElement.deleteRow(amountOfQuestions)
						}
					}
				});
			saveQBut.appendTo(cell3)
		})
		$('#addSection').on('click',function () {
			var table = document.getElementById("sTable");
			var tbody = table.children[1];
			let amountOfQuestions = tbody.children.length;
// Create an empty <tr> element and add it to the 1st position of the table:
			var row = table.insertRow(amountOfQuestions+1);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);

// Add some text to the new cells:
			cell1.innerHTML = amountOfQuestions+1;
			cell2.innerHTML = "New Section";
			cell2.setAttribute("colspan",2);
			cell2.setAttribute("contenteditable",'true');
		})
		$('#save').on('click',function () {
			$.ajax({
				url: window.origin+'/a18ux02/Caregiver/updateQuestionnairie',
				method: 'post',
				dataType: 'json',
				data: {
					//DATA
				},
				success: function(idNote) {
					//NOTI CG
				}
			});
		})
	})


	var sections = "";
	var questionsDB = "";
	function clean(obj) {
		for (var propName in obj) {
			if (obj[propName] === null || obj[propName] === undefined) {
				delete obj[propName];
			}
		}
		console.log("CLEAN DB")
		console.log(obj)
	}
	function populateSections() {
		sections = <?php echo json_encode($sections)?>;
		var table = document.getElementById("sTable");
		var tbody = document.createElement("tbody");

		var elements = [];
		for (var i = 0 ; i < sections.length ; i++)
		{
			var sectionName = sections[i]["sectionType"];
			console.log(sectionName)
			//CREATE ROW FOR EVERY SECTION
			var row = document.createElement('tr');

			var col1 = document.createElement('td');
			console.log(i+1)
			col1.innerHTML = i+1
			row.appendChild(col1)
			var col2 = document.createElement('td');
			col2.innerHTML = sectionName
			col2.setAttribute("colspan",2)
			row.appendChild(col2)

			tbody.appendChild(row);
		}
		table.appendChild(tbody)

		questionsDB = <?php echo json_encode($questions)?>;
		let questionsSections1 = questionsDB.filter(e => e.questionType == 1);
		var table2 = document.getElementById("qTable");
		var tbody = document.createElement("tbody");

		var elements = [];
		//CREATE ROW FOR EVERY Question of first section
		for (var i = 0 ; i < questionsSections1.length ; i++)
		{
			var questionName = questionsSections1[i]["questionText"];
			var row = document.createElement('tr');
			var col1 = document.createElement('td');
			col1.innerHTML = i+1
			row.appendChild(col1)
			var col2 = document.createElement('td');
			col2.setAttribute("colspan",2);
			col2.innerHTML = questionName
			row.appendChild(col2)
			tbody.appendChild(row);
		}
		table2.appendChild(tbody)

	}
	function init() {
		$('#sTable tbody').on('click', 'tr', function() {
			if(this.firstChild.innerHTML != "Section") {
				setQuestionTable(this.firstChild.innerHTML)
			}
		})
	}

	function setQuestionTable(id){
		lastSectionClicked = id;
		let questionsSections1 = questionsDB.filter(e => e.questionType == id);
		var table2 = document.getElementById("qTable");
		var old_tbody =table2.children[1];
		var tbody = document.createElement("tbody");

		var elements = [];
		//CREATE ROW FOR EVERY Question of first section
		for (var i = 0 ; i < questionsSections1.length ; i++)
		{
			var questionName = questionsSections1[i]["questionText"];
			var row = document.createElement('tr');
			var col1 = document.createElement('td');
			col1.innerHTML = i+1
			row.appendChild(col1)
			var col2 = document.createElement('td');
			col2.innerHTML = questionName
			col2.setAttribute("colspan",2);
			row.appendChild(col2)
			tbody.appendChild(row);
		}
		old_tbody.parentNode.replaceChild(tbody, old_tbody)
	}




</script>
</body>
</html>
