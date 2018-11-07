<?php
$dsn = 'mysql:host=mysql.studev.groept.be;dbname=a18ux02';
$username = 'a18ux02';
$password = 'p64nbw02qr';


//setting the timeZone
date_default_timezone_set('Europe/Brussels');
// Create connection
try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$room_number = $_POST['room_number'];

echo $room_number;

$sql = "SELECT * FROM Resident WHERE room='$room_number'";
$result = $dbh->query($sql);
if (($result->rowCount() > 0)) {
	echo "success";
	exit;
} else {
	echo "fail";
	exit;
}

$dbh = null;
?>
