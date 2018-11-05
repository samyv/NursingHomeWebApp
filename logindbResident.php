<?php
$servername = "mysql.studev.groept.be";
$username = "a18ux02";
$password = "p64nbw02qr";
$dbname = "a18ux02";
//setting the timeZone
date_default_timezone_set('Europe/Brussels');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$room_number = $_POST['room_number'];

echo $room_number;

$sql = "SELECT * FROM Resident WHERE room='$room_number'";
$result = $conn->query($sql);
if (($result->num_rows > 0)) {
	echo "succes";
	exit;
} else {
	echo "fail";
	exit;
}
$conn->close();
?>
