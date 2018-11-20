<!DOCTYPE html>
<html>
<head>
	<title>Database Searching</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/searchForResident.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--    <script src="javascript/search.js"></script>-->

</head>

<body>

<h1>Database searching</h1>

<body>
<input type="text" id="myInput" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
<div class="carlist">
	<table id="myTable"></table>
</div>


<script>
	window.onload = function (ev) {
		populate();
		init();
	};
	var list,name;
	function search() {
		var input, filter, table, i;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		table = document.getElementById("myTable");
		list = document.getElementsByTagName('tr');
		for (i = 1; i <= list.length; i++) {
			// console.log(list[i])
			if(list[i] != undefined) {
				name = list[i].getElementsByTagName("td")[1].innerHTML;
				// console.log(name);

				if (name.toUpperCase().indexOf(filter) > -1) {
					list[i].style.display = "";
				} else {
					list[i].style.display = "none";
				}
			}
		}
	}

	function populate()
	{
		var database = "";
		database = <?php echo json_encode($listCar)?>;
		var table = document.getElementById("myTable");
		var tbody = document.createElement("tbody");
		var row = document.createElement('tr');
		var id = document.createElement('th');
		// id.style.display = "block";
		id.innerHTML = "ID"
		row.appendChild(id);

		var col1 = document.createElement('th');
		col1.innerHTML = "Name";
		row.appendChild(col1)
		var col2 = document.createElement('th');
		col2.innerHTML = "Floor";
		row.appendChild(col2)
		var col3 = document.createElement('th');
		col3.innerHTML = "Age";
		row.appendChild(col3)
		tbody.appendChild(row)
		var elements = [];
		for (var i = 0 ; i < database.length ; i++)
		{
			var element = getElements(database[i]);
			elements.push(element);

			var row = document.createElement('tr');

			var id = document.createElement('td');
			id.innerHTML = element.id;
			// id.style.display = "block"
			row.appendChild(id);
			var col1 = document.createElement('td');
			col1.innerHTML = element.name
			row.appendChild(col1)
			var col2 = document.createElement('td');
			col2.innerHTML = element.floor;
			row.appendChild(col2)
			var col3 = document.createElement('td');
			col3.innerHTML = element.age;
			row.appendChild(col3)
			tbody.appendChild(row);
		}
		table.appendChild(tbody)
	}

	function getElements(db_element) {
		var element = {}
		element.id = db_element['residentID'];
		element.name = db_element['firstname'] +" " + db_element['lastname'];
		element.floor = db_element['floor'];
		var date = db_element['birthdate'].split("-");
		element.age  = calculate_age(new Date(date[0],date[1],date[2]));
		return element;
	}
	function calculate_age(date) {
		var diff_ms = Date.now() - date.getTime();
		var age_dt = new Date(diff_ms);
		return Math.abs(age_dt.getUTCFullYear() - 1970);
	}

	function init() {
		$('#myTable tbody').on('click', 'tr', function() {
			var id_td = this.firstChild;
			var test = id_td.innerHTML;

			console.log(window.location.href);
			window.location.href =  "http://localhost/a18ux02/searchRes"+"?uid="+test;
			<?php
			if(isset($_GET['uid'])){
				$id = $_GET['uid'];
				redirect('resDash/'."?id=".$id);
			}
			?>
		})
	}
</script>
</body>
</html>
