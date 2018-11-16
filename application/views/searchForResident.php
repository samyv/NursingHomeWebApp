<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<!--    <script src="javascript/search.js"></script>-->

    <link rel="stylesheet" href="assets/css/searchForResident.css">
</head>
<body>

<h1>Database searching</h1>

<body>
<input type="text" id="myInput" onkeyup="search()" placeholder="Search for names.." title="Type in a name">

<!--<ul id="myUL">-->
<!---->
<!--</ul>-->

<table id="myTable">
	<tr>
		<th>Name</th>
		<th>Floor</th>
		<th>Age</th>
	</tr>
	<tr>
		<th>Company</th>
		<th>Contact</th>
		<th>Country</th>
	</tr>
	<tr>
		<td>Alfreds Futterkiste</td>
		<td>Maria Anders</td>
		<td>Germany</td>
	</tr>
	<tr>
		<td>Berglunds snabbköp</td>
		<td>Christina Berglund</td>
		<td>Sweden</td>
	</tr>
	<tr>
		<td>Centro comercial Moctezuma</td>
		<td>Francisco Chang</td>
		<td>Mexico</td>
	</tr>
	<tr>
		<td>Ernst Handel</td>
		<td>Roland Mendel</td>
		<td>Austria</td>
	</tr>
	<tr>
		<td>Island Trading</td>
		<td>Helen Bennett</td>
		<td>UK</td>
	</tr>
	<tr>
		<td>Königlich Essen</td>
		<td>Philip Cramer</td>
		<td>Germany</td>
	</tr>
	<tr>
		<td>Laughing Bacchus Winecellars</td>
		<td>Yoshi Tannamuri</td>
		<td>Canada</td>
	</tr>
	<tr>
		<td>Magazzini Alimentari Riuniti</td>
		<td>Giovanni Rovelli</td>
		<td>Italy</td>
	</tr>
	<tr>
		<td>North/South</td>
		<td>Simon Crowther</td>
		<td>UK</td>
	</tr>
	<tr>
		<td>Paris spécialités</td>
		<td>Marie Bertrand</td>
		<td>France</td>
	</tr>
</table>

<script>
	window.onload = populate;

	function search() {
		var input, filter, ul, li, a, i;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		ul = document.getElementById("myUL");
		li = ul.getElementsByTagName("li");
		for (i = 0; i < li.length; i++) {
			a = li[i].getElementsByTagName("a")[0];
			if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
				li[i].style.display = "";
			} else {
				li[i].style.display = "none";
			}
		}
	}

	function populate()
	{
		var database = "";
		database = <?php echo json_encode($listCar)?>;
		var table = document.getElementById("myTable");

		for (var i = 0 ; i < database.length ; i++)
		{
			var date = database[i]['birthdate'].split("-");
			var row = document.createElement('tr');
			var name = database[i]['firstname'] +" " + database[i]['lastname'];
			var floor = database[i]['floor'];
			var age = calculate_age(new Date(date[0],date[1],date[2]));

			var col1 = document.createElement('th');
			col1.innerHTML = name;
			row.appendChild(col1)
			var col2 = document.createElement('th');
			col2.innerHTML = floor;
			row.appendChild(col2)
			var col3 = document.createElement('th');
			col3.innerHTML = age;
			row.appendChild(col3)
			table.appendChild(row);
		}
	}

	function calculate_age(date) {
		var diff_ms = Date.now() - date.getTime();
		var age_dt = new Date(diff_ms);
		return Math.abs(age_dt.getUTCFullYear() - 1970);
	}
</script>
</body>
</html>
