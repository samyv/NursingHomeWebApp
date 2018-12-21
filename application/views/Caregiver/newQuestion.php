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
			let amountQuestions = tbody.children.length;
// Create an empty <tr> element and add it to the 1st position of the table:
			var row = table.insertRow(amountQuestions+1);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);

// Add some text to the new cells:
			cell1.innerHTML = amountQuestions+1;
			cell2.innerHTML = "New Question";
			cell2.setAttribute("contenteditable",'true');
			let saveSBut = $('<button/>',
				{
					text: 'save',
					id: "saveQuestion",
					click: saveQuestion
				}
			);
			saveSBut.appendTo(cell3)
		})

		$('#addSection').on('click',function () {
			var table = document.getElementById("sTable");
			var tbody = table.children[1];
			let amountSections = tbody.children.length;
// Create an empty <tr> element and add it to the 1st position of the table:
			var row = table.insertRow(amountSections+1);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);

// Add some text to the new cells:
			cell1.innerHTML = amountSections+1;
			cell2.innerHTML = "New Section";
			cell2.setAttribute("contenteditable",'true');

			let saveSBut = $('<button/>',
				{
					text: 'save',
					id: "saveSection",
					click: saveSection
				});
			saveSBut.appendTo(cell3)
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
		function saveQuestion() {
			if(this.innerHTML == "save") {
				//FIND VALUES FOR NEW Section
				var lastQuestionTotal = questionsDB.slice(-1)[0];
				console.log(lastQuestionTotal)
				var lastID = parseInt(lastQuestionTotal.idQuestion);
				//PK
				let newQID = lastID + 1;
				//FIND PosNum AND nextQuestion with lastQuestion of the same section
				var lastQuestion = questionsDB.filter(e => e.questionType == lastSectionClicked).slice(-1)[0]
				console.log(lastQuestion)
				let newPosNum = undefined;
				let prevID = undefined;
				let newNextQuestionID = undefined;

				//EXISTING SECTION
				if(lastQuestion) {
					newPosNum = parseInt(lastQuestion.positionNum)+1;
					newNextQuestionID = lastQuestion.nextQuestionId;
					prevID = lastQuestion.idQuestion;
					lastQuestion.nextQuestionId = (newQID).toString();
					let nextQuestion = questionsDB.filter(q => q.idQuestion == newNextQuestionID).slice(-1)[0]
					console.log(nextQuestion)
					nextQuestion.previousQuestionId = newQID.toString();

					//NEW SECTION
				} else{
					newPosNum = 1;
					let lastSectionID = parseInt(sections.slice(-1)[0].sectionId)-1
					console.log(lastSectionID)
					let questionslastS = questionsDB.filter(q => q.questionType == lastSectionID).slice(-1)[0]
					console.log(questionslastS);
					newNextQuestionID = "NULL";
					prevID = questionslastS.idQuestion;
					questionslastS.nextQuestionId = newQID.toString();
				}

				var newQuestion = {
					idQuestion: newQID.toString(),
					questionText: this.parentElement.parentElement.children[1].innerText,
					nextQuestionId: newNextQuestionID.toString(),
					previousQuestionId: prevID.toString(),
					positionNum: newPosNum.toString(),
					questionType: lastSectionClicked.toString()
				}
				questionsDB.push(newQuestion)
				this.innerHTML = "delete";
			}
			//DELETE NOT WORKING YET
			else {
				var questionToErase = questionsDB.filter(e => e.questionType == lastSectionClicked && e.positionNum == this.parentElement.parentElement.children[0].innerText).slice(-1)[0]
				console.log(questionToErase)
				var nextQuestionID = questionToErase.nextQuestionId;
				var prevQuestionID = questionToErase.previousQuestionId;
				var prevQuestion = questionsDB.filter(e => e.idQuestion == prevQuestionID).slice(-1)[0]
				var nextQuestion = questionsDB.filter(e => e.idQuestion == nextQuestionID).slice(-1)[0]
				prevQuestion.nextQuestionId = nextQuestionID.toString();
				if(nextQuestion){
					nextQuestion.previousQuestionId = prevQuestionID.toString();
				}
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
		function saveSection(){
			if(this.innerHTML == "save") {
				//FIND VALUES FOR NEW Section
				var lastSection = sections.slice(-1)[0];
				var lastID = parseInt(lastSection.sectionId);
				//PK
				let newQID = lastID + 1;
				var newSection = {
					sectionId: newQID.toString(),
					sectionText: "volgend onderwerp is: "+this.parentElement.parentElement.children[1].innerText,
					sectionTyp: this.parentElement.parentElement.children[1].innerText
				}
				sections.push(newSection);
				this.innerHTML = "delete";
			} else {
				var sectionToErase = sections.filter(e =>  e.sectionId == this.parentElement.parentElement.children[0].innerText).slice(-1)[0]
				var key = null;
				for (var prop in sections)
				{
					if (sections.hasOwnProperty(prop))
					{
						if (sections[prop] === sectionToErase)
						{
							key = prop;
						}
					}
				}
				delete sections.key
				clean(sections)

				let tbody = this.parentElement.parentElement.parentElement;
				let amountOfSections = tbody.children.length;
				this.parentElement.parentElement.parentElement.parentElement.deleteRow(amountOfSections)
			}

	};
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
