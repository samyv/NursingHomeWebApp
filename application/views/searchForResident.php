<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="javascript/search.js"></script>
    <link rel="stylesheet" href="assets/css/searchForResident.css">
</head>
<body>

<h1>Database searching</h1>

<body>
<input type="text" id="myInput" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
<?php
?>
<ul id="myUL">
	{listCar}
	<li>{firstname} {lastname}</li>
	{/listCar}
</ul>


</body>
</html>
