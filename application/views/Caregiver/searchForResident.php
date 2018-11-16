<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<!--    <script src="javascript/search.js"></script>-->

    <link rel="stylesheet" href="<?=base_url();?>assets/css/searchForResident.css">
</head>
<body>

<h1>Database searching</h1>

<body>
<input type="text" id="myInput" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
<?php
?>
<ul id="myUL">

</ul>

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

var database;
	var list;

	function populate()
	{

		database = <?php echo json_encode($listCar)?>;
		list = document.getElementById("myUL");

		for (var i = 0 ; i < database.length ; i++)
		{
			var element = document.createElement('li');
			var name = database[i]['firstname'] +" " + database[i]['lastname'];
			element.innerHTML = '<a href="#">' + name + '</a>';
			list.appendChild(element);
		}
	}
</script>
</body>
</html>
