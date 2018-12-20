<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>{page_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/searchForResident.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="assets/css/transitions.css">
	<!--    <script src="javascript/search.js"></script>-->

</head>

<body>

<div class="grid-container fade-in	">
<div class = "h1">
    <h1>
        <?php echo ($this->lang->line('title database search'));?>
    </h1>
</div>

<div class = "search">
    <input type="text" id="myInput" class= "form-control" onkeyup="search()" title="Type in a name"
           placeholder=<?php echo ($this->lang->line('search'));?> >
</div>

<div class="table">
	<table id="myTable"></table>
</div>

<script>
	$(function() {
		populate();
		init();
	});
	var list,name,room;
	function search() {
		var input, filter, table, i;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		console.log(filter)
		table = document.getElementById("myTable");
		list = document.getElementsByTagName('tr');
		for (i = 1; i <= list.length; i++) {
			if(list[i] != undefined) {
				name = list[i].getElementsByTagName("td")[1].innerHTML;
				room = list[i].getElementsByTagName("td")[3].innerHTML;
				console.log("room: "+room);
				console.log("filter: "+filter);
				console.log(room.indexOf(filter));
				if ((name.toUpperCase().indexOf(filter) > -1) || (room.indexOf(filter) > -1))  {
					list[i].style.display = "";
				} else {
					list[i].style.display = "none";
				}
			}
		}
	}

	function populate() {
		var database = "";
		database = <?php echo json_encode($listCar)?>;
		var table = document.getElementById("myTable");
		var tbody = document.createElement("tbody");
		var tbodyH = document.createElement("tbody");
		var row = document.createElement('tr');
		var id = document.createElement('th');
		// id.style.display = "block";
		id.innerHTML = "ID";
		row.appendChild(id);

		var col1 = document.createElement('th');
		col1.innerHTML ="<?php echo($this->lang->line('name'));?>";
		row.appendChild(col1)
		var col2 = document.createElement('th');
		col2.innerHTML ="<?php echo($this->lang->line('floor'));?>";
		row.appendChild(col2)
		var col3 = document.createElement('th');
		col3.innerHTML ="<?php echo($this->lang->line('room'));?>";
		row.appendChild(col3)
		tbody.appendChild(row)
		var elements = [];
		for (var i = 0 ; i < database.length ; i++)
		{
			var element = getElements(database[i]);
			console.log(element)
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
			col3.innerHTML = element.room;
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
		element.room  = db_element['room'];
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
			window.location.href =  "<?php base_url()?>searchRes"+"?uid="+test;
			<?php
			if(isset($_GET['uid'])){
				$id = $_GET['uid'];
				redirect('resDash/'."?id=".$id);
			}
			?>
		})
	}
</script>
</div>
</body>
</html>
