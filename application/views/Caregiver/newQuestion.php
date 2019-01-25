<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/newQuestion.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/transitions.css">
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
			<button id="reset">RESET</button>
		</div>
	</div>
<script type="text/javascript">
	let lastSectionClicked = 1;
	var sections = "";
	var questionsDB = "";
	var backupQuestions;

	//JQUERY FUNCTION THAT IS CALLED WHEN PAGE IS LOADING
	$(function () {
		populateSections();
		lastSectionClicked = 1;

		//FUNCTION THAT CALLS SETQUESTIONTABLE WHEN A DIFFERENT SECTION IS CLICKED ON
		$('#sTable tbody').on('click', 'tr', function() {
			if(this.firstChild.innerHTML != "Section") {
				console.log(this.firstChild.innerHTML)
				setQuestionTable(this.firstChild.innerHTML)
			}
		})

		//FUNCTION THAT ADDS A NEW QUESTION WHEN CLICKED ON THE BUTTON IN HEADER
		$('#addQuestion').on('click',function () {
			//SELECT QUESTION TABLE, FIND AMOUNT OF QUESTIONS IN SELECTED SECTION
			var table = document.getElementById("qTable");
			var tbody = table.children[1];

			//CREATE A NEW ROW FOR THE QUESTION
			var row = tbody.insertRow(tbody.children.length);

			// create new cells (<td> elements) that are inserted in the row
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);

			// Add some text to the new cell 1 and 2
			cell1.innerHTML = tbody.children.length;
			cell2.innerHTML = "New Question";
			cell2.setAttribute("contenteditable",'true');

			//create a button and append it to CELL 3
			let saveSBut = $('<button/>',
				{
					text: 'save',
					id: "saveQuestion",
					click: saveQuestion
				}
			);
			saveSBut.appendTo(cell3)
		})

		//FUNCTION THAT ADDS A NEW SECTION WHEN CLICKED ON THE BUTTON IN HEADER
		$('#addSection').on('click',function () {
			//SELECT QUESTION TABLE, FIND AMOUNT OF QUESTIONS IN SELECTED SECTION
			var table = document.getElementById("sTable");
			var tbody = table.children[1];
			let amountSections = tbody.children.length;

			//CREATE A NEW ROW FOR THE QUESTION
			var row = table.insertRow(amountSections+1);

			// create new cells (<td> elements) that are inserted in the row
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);

			// Add some text to the new cell 1 and 2:
			cell1.innerHTML = amountSections+1;
			cell2.innerHTML = "New Section";
			cell2.setAttribute("contenteditable",'true');

			//create a button and append it to CELL 3
			let saveSBut = $('<button/>',
				{
					text: 'save',
					id: "saveSection",
					click: saveSection
				});
			saveSBut.appendTo(cell3)
		})

		//SAVE THE QUESTIONNARRIE AND SEND IT TO THE DATABASE
		$('#save').on('click',function () {
			let request = $.ajax({
				url: window.origin+'/a18ux02/Caregiver/updateQuestionnairie',
				method: 'post',
				dataType: 'json',
				data: {
					'questions' : questionsDB
				},
			});
			request.done(function (response,textStatus,jqXHR) {
				alert("Questions are saved!")
			})
		})

		$('#reset').on('click',function () {
			let request = $.ajax({
				url: window.origin+'/a18ux02/Caregiver/updateQuestionnairie',
				method: 'post',
				dataType: 'json',
				data: {
					'questions' : backupQuestions
				},
			});
			request.done(function (response,textStatus,jqXHR) {
				alert("Questions are restored!")
				populateSections();
				lastSectionClicked = 1;
			})
		})
	})
	//FUNCTION THAT INSERTS THE NEW QUESTION INTO QUESTIONDB AND UPDATES THE PREV AND NEXT SECTIONS
	let glob_but;
	function saveQuestion() {
			if(this.innerHTML == "save") {
				//FIRST FIND THE PK ID => LAST ELEMENT ID +1
				var lastQuestionTotal = questionsDB.slice(-1)[0];
				var lastID = parseInt(lastQuestionTotal.idQuestion);
				let newQID = lastID + 1;


				//CREATE VARIABLES WE NEED FOR THE NEW QUESTION
				let newPosNum = undefined;    		//#QUESTION IN THE SECTION
				let newPrevID = undefined;				//ID OF PREVIOUS QUESTION
				let newNextQuestionID = undefined;	//ID OF NEXT QUESTION

				//SELECT LAST QUESTION OF SELECTED SECTION. IF NEW SECTION THIS IS UNDEFINED!
				var lastQuestionThisSection = questionsDB.filter(e => e.questionType == lastSectionClicked).slice(-1)[0]

				//NOW IT DEPENDS IF IT IS A NEW SECTION OR AN EXISTING ONE THAT IS SELECTED, CHECK IF LASTQUESTIONTHISSECTION IS DEFINED
				if(lastQuestionThisSection) {
					//SECTION HAS PREVIOUS QUESTIONS!

					//NEWPOSNUM = LASTQS POSNUM ++
					newPosNum = parseInt(lastQuestionThisSection.positionNum)+1;

					//ID NEXT QUESTION = NEXTQID of LASTQS
					newNextQuestionID = lastQuestionThisSection.nextQuestionId;

					//PREVID = ID LASTQS
					newPrevID = lastQuestionThisSection.idQuestion;

					//LOOK IF THERE IS A NEXTQ, IF YES => UPDATE ITS PREVID
					let nextQuestion = questionsDB.filter(q => q.idQuestion == newNextQuestionID).slice(-1)[0]
					if(nextQuestion){
						nextQuestion.previousQuestionId = newQID;
					}

					//UPDATES NEXTID OF LASTQUESTIONSECTION
					lastQuestionThisSection.nextQuestionId = newQID;

				//NEW SECTION
				} else{
					console.log("new section");
					//FIRST QUESTION SO POSNUM = 1
					newPosNum = 1;

					//CHECK IF THERE IS A PREV SECTION
					let prevSectionID = parseInt(sections.slice(-1)[0].sectionId)-1;
					if(prevSectionID > 0){
						//YESS => FIND LASTQ of that SECTION
						let questionPrevSection = questionsDB.filter(q => q.questionType == prevSectionID).slice(-1)[0];
						//CHECK IF IT EXISTS
						if(questionPrevSection){
							//UPDATE ITS NEXTID IF SO
							questionPrevSection.nextQuestionId = newQID;

							//NEWPREVID = HIS ID
							newPrevID = questionPrevSection.idQuestion;

							//FIND THE NEXT QUESTION
							let nextQuestionID = questionPrevSection.nextQuestionId;
							let nextQuestion = questionsDB.filter(q => q.questionType == nextQuestionID)[0];
							//CHECK IF IT EXISTS
							if(nextQuestion){
								//YES => update its PREVID AND NEWNEXTID = HISID
								nextQuestion.previousQuestionId = newQID;
								newNextQuestionID = nextQuestion.idQuestion;
							} else {
								newNextQuestionID = undefined;
							}
						} else {
							//IF THERE IS NO QUESTION IN PREVIOUS SECTION WE STILL NEED TO FIND IT FOR NEXT QUESTION
							let nextSectionID = prevSectionID + 2;
							//CHECK IF SECTION EXISTS
							if(nextSectionID <= sections.length){
								//YES
								let firstQuestionNextSection = questionsDB.filter(q => q.questionType == nextSectionID)[0];
								//CHECK IF QUESTION EXISTS
								if(firstQuestionNextSection){
									newNextQuestionID = firstQuestionNextSection.idQuestion;
									firstQuestionNextSection.previousQuestionId = newQID;
								}
							}
						}
					}
				}

				var newQuestion = {
					idQuestion: newQID.toString(),
					questionText: this.parentElement.parentElement.children[1].innerText,
					nextQuestionId: newNextQuestionID==undefined?undefined:newNextQuestionID.toString(),
					previousQuestionId: newPrevID.toString(),
					positionNum: newPosNum.toString(),
					questionType: lastSectionClicked.toString()
				}
				questionsDB.push(newQuestion)
				this.innerHTML = "delete";
			}

			//DELETE NOT WORKING YET
			else {
				var questionToErase = questionsDB.filter(e => e.questionType == lastSectionClicked && e.positionNum == this.parentElement.parentElement.children[0].innerText)[0]
				console.log(this.parentElement.parentElement.children[0].innerText)
				var nextQuestionID = questionToErase.nextQuestionId;
				var prevQuestionID = questionToErase.previousQuestionId;
				var prevQuestion = questionsDB.filter(e => e.idQuestion == prevQuestionID).slice(-1)[0]
				var nextQuestion = questionsDB.filter(e => e.idQuestion == nextQuestionID).slice(-1)[0]
				if(prevQuestion){
					prevQuestion.nextQuestionId = nextQuestionID==undefined?undefined:nextQuestionID.toString();
				}
				if(nextQuestion){
					nextQuestion.previousQuestionId = prevQuestionID==undefined?undefined:prevQuestionID.toString();
				}

				//DELETE IN QDB
				for (var prop in questionsDB) {
					if (questionsDB.hasOwnProperty(prop))
					{
						if (questionsDB[prop] === questionToErase)
						{
							console.log("key to erase: "+prop)
							questionsDB.splice(prop,1);
						}
					}
				}

				//UPDATE POSNUM
				let questionsSections = questionsDB.filter(e => e.questionType == lastSectionClicked)
				var i = 1;
				for(var question in questionsSections){
					console.log(i)
					question.positionNum = i;
					i++;
				}

				//DELETE THE ROW IN THE TABLE
				var row_index = $(this).closest("tr").index();

				//UPDATE TABLE INDEX
				let tbody = $(this).closest("td").closest("tr").parent();
				console.log(this.parentElement.parentElement.parentElement.parentElement)
				console.log($(this).closest("td").closest("tr").parent())
				glob_but = $(this)
				let rows = this.parentElement.parentElement.parentElement.children;
				console.log(rows)
				this.parentElement.parentElement.parentElement.parentElement.deleteRow(row_index+1)
				for(let j = 0; j < rows.length;j++){
					console.log(rows[j])
					rows[j].firstElementChild.innerText = j+1;
				}
			}
		}

	//FUNCTION THAT INSERTS THE NEW SECTION INTO SECTIONS AND UPDATES THE PREV AND NEXT SECTIONS
	function saveSection() {
		if (this.innerHTML == "save") {
			//FIND VALUES FOR NEW Section
			var lastSection = sections.slice(-1)[0];
			var lastID = parseInt(lastSection.sectionId);
			//PK
			let newQID = lastID + 1;
			var newSection = {
				sectionId: newQID.toString(),
				sectionText: "volgend onderwerp is: " + this.parentElement.parentElement.children[1].innerText,
				sectionTyp: this.parentElement.parentElement.children[1].innerText
			}
			sections.push(newSection);
			this.innerHTML = "delete";
		} else {
			console.log(this.parentElement.parentElement.children[0].innerText)
			var sectionToErase = sections.filter(e => e.sectionId == this.parentElement.parentElement.children[0].innerText).slice(-1)[0]
			console.log(sectionToErase)
			//DELETE IN sections
			for (var prop in sections) {
				if (sections.hasOwnProperty(prop)) {
					if (sections[prop] === sectionToErase) {
						console.log("section delete!")
						console.log(prop)
						sections.splice(prop, 1);
					}
				}
			}

			//DELETE THE ROW IN THE TABLE
			var row_index = $(this).closest("tr").index();

			//UPDATE TABLE INDEX
			let tbody = $(this).closest("td").closest("tr").parent();
			let rows = this.parentElement.parentElement.parentElement.children;
			this.parentElement.parentElement.parentElement.parentElement.deleteRow(row_index + 1)
			for (let j = 0; j < rows.length; j++) {
				console.log(rows[j])
				rows[j].firstElementChild.innerText = j + 1;
			}

			var questionsOfSection = questionsDB.filter(q => q.questionType == this.parentElement.parentElement.children[0].innerText)
			console.log(questionsOfSection)
			let sectionCleared = false;
			for (var prop in questionsDB) {
				if (questionsDB.hasOwnProperty(prop)) {
					for (var toDelete in questionsOfSection) {
						// console.log(questionsDB[prop])
						// console.log(questionsOfSection[toDelete])
						if (questionsDB[prop] === questionsOfSection[toDelete]) {
							console.log("key to erase: " + prop)
							sectionCleared = true;
							questionsDB.splice(prop, 1);
						}
					}
					//ERROR ERROR ERROR
					if(sectionCleared){
						if (questionsDB.hasOwnProperty(prop)) {
							questionsDB[prop].sectionId = questionsDB[prop].sectionId - 1;
						}
					}
				}
			}

			for(var prop in questionsDB){
				console.log(questionsDB[prop].sectionId)
			}
		}
	};

	//REMOVE EMPTY PROPS IN OBJECT
	function clean(obj) {
		for (var propName in obj) {
			if (obj[propName] === null || obj[propName] === undefined) {
				console.log("here")
				delete obj[propName];
			}
		}
		console.log("CLEAN DB")
		console.log(obj)
	}

	//IS CALLED WHEN PAGE IS LOADING: POPULATE THE SECTIONSTABEL
	function populateSections() {
		sections = <?php echo json_encode($sections)?>;
		var table = document.getElementById("sTable");
		var tbody = document.createElement("tbody");

		var elements = [];
		for (var i = 0 ; i < sections.length ; i++)
		{
			var sectionName = sections[i]["sectionType"];
			//CREATE ROW FOR EVERY SECTION
			var row = document.createElement('tr');

			var col1 = document.createElement('td');
			console.log(i+1)
			col1.innerHTML = i+1
			row.appendChild(col1)
			var col2 = document.createElement('td');
			col2.innerHTML = sectionName
			row.appendChild(col2)
			var col3 = document.createElement('td');
			let saveSBut = $('<button/>', {
				text: 'delete',
				id: "saveSection",
				click: saveSection
			});
			saveSBut.appendTo(col3)
			row.appendChild(col3)


			tbody.appendChild(row);
		}
		table.appendChild(tbody)

		questionsDB = <?php echo json_encode($questions)?>;
		backupQuestions = questionsDB;
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
			col2.innerHTML = questionName
			row.appendChild(col2)
			var col3 = document.createElement('td');
			let saveQBut = $('<button/>', {
					text: 'delete',
					id: "saveQuestion",
					click: saveQuestion
				});
			saveQBut.appendTo(col3)
			row.appendChild(col3)
			tbody.appendChild(row);
		}
		table2.appendChild(tbody)
	}

	//UPDATES THE QUESTIONTABLE BASED ON THE ID OF THE SECTION
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
			// col2.setAttribute(2);
			row.appendChild(col2)
			var col3 = document.createElement('td');
			let saveQBut = $('<button/>', {
				text: 'delete',
				id: "saveQuestion",
				click: saveQuestion
			});
			saveQBut.appendTo(col3)
			row.appendChild(col3)
			tbody.appendChild(row);
		}
		old_tbody.parentNode.replaceChild(tbody, old_tbody)
	}

</script>
</body>
</html>
