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

<ul id="myUL">

    <?php

	foreach( $array as $a ): ?>
        <li><a href="#"> <?= $a ?> </a></li>
    <?php endforeach; ?>
</ul>


</body>
</html>
