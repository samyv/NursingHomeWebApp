<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/searchForResident.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="javascript/search.js"></script>

</head>

<body>

<h1>Database searching</h1>

<body>
<input type="text" id="myInput" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
<div class="carlist">
	<table id="myTable"></table>
</div>

<h1 style="text-align: center; color: red; " id="hidden">I was hidden</h1>

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
				name = list[i].getElementsByTagName("td")[0].innerHTML;
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
		for (var i = 0 ; i < database.length ; i++)
		{
			var date = database[i]['birthdate'].split("-");
			var row = document.createElement('tr');

			var name = database[i]['firstname'] +" " + database[i]['lastname'];
			var floor = database[i]['floor'];
			var age = calculate_age(new Date(date[0],date[1],date[2]));
			var col1 = document.createElement('td');
			col1.innerHTML = name;
			row.appendChild(col1)
			var col2 = document.createElement('td');
			col2.innerHTML = floor;
			row.appendChild(col2)
			var col3 = document.createElement('td');
			col3.innerHTML = age;
			row.appendChild(col3)
			tbody.appendChild(row);
		}
		table.appendChild(tbody)
	}

	function calculate_age(date) {
		var diff_ms = Date.now() - date.getTime();
		var age_dt = new Date(diff_ms);
		return Math.abs(age_dt.getUTCFullYear() - 1970);
	}
</script>
</body>
</html>
