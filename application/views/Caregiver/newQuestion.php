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
			<table id="sTable"></table>
		</div>
		<div class="questionTable">
			<table id="qTable"></table>
		</div>
	</div>
<script type="text/javascript">
	$(function () {
		populateSections();
		init();
	})


	var sections = "";
	var questionsDB = "";
	function populateSections()
	{
		sections = <?php echo json_encode($sections)?>;
		var table = document.getElementById("sTable");
		var tbody = document.createElement("tbody");
		var row = document.createElement('tr');

		var col1 = document.createElement('th');
		col1.innerHTML = "#";
		row.appendChild(col1)
		var col1 = document.createElement('th');
		col1.innerHTML = "Section";
		row.appendChild(col1)
		// var col2 = document.createElement('th');
		// col2.innerHTML = "#Questions";
		// row.appendChild(col2)
		tbody.appendChild(row)

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
			row.appendChild(col2)

			tbody.appendChild(row);
		}
		table.appendChild(tbody)

		questionsDB = <?php echo json_encode($questions)?>;
		let questionsSections1 = questionsDB.filter(e => e.questionType == 1);
		var table2 = document.getElementById("qTable");
		var tbody = document.createElement("tbody");
		var row = document.createElement('tr');

		var col1 = document.createElement('th');
		col1.innerHTML = "Question";
		row.appendChild(col1)
		// var col2 = document.createElement('th');
		// col2.innerHTML = "#Questions";
		// row.appendChild(col2)
		tbody.appendChild(row)

		var elements = [];
		//CREATE ROW FOR EVERY Question of first section
		for (var i = 0 ; i < questionsSections1.length ; i++)
		{
			var questionName = questionsSections1[i]["questionText"];
			var row = document.createElement('tr');
			var col1 = document.createElement('td');
			col1.innerHTML = questionName
			row.appendChild(col1)
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
		let questionsSections1 = questionsDB.filter(e => e.questionType == id);
		var table2 = document.getElementById("qTable");
		var old_tbody =table2.firstChild;
		var tbody = document.createElement("tbody");
		var row = document.createElement('tr');

		var col1 = document.createElement('th');
		col1.innerHTML = "Question";
		row.appendChild(col1)
		// var col2 = document.createElement('th');
		// col2.innerHTML = "#Questions";
		// row.appendChild(col2)
		tbody.appendChild(row)

		var elements = [];
		//CREATE ROW FOR EVERY Question of first section
		for (var i = 0 ; i < questionsSections1.length ; i++)
		{
			var questionName = questionsSections1[i]["questionText"];
			var row = document.createElement('tr');
			var col1 = document.createElement('td');
			col1.innerHTML = questionName
			row.appendChild(col1)
			tbody.appendChild(row);
		}
		old_tbody.parentNode.replaceChild(tbody, old_tbody)
	}




</script>
</body>
</html>
