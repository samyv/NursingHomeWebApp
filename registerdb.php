<?php

$servername = "mysql.studev.groept.be";
$username = "a18ux02";
$password = "p64nbw02qr";
$dbname = "a18ux02";
$mysqli = new mysqli($servername, $username, $password, $dbname);

$email = $_POST['email'];
$psw_dec = $_POST['psw'];
$psw = md5($psw_dec);
$psw2 = md5($_POST['psw2']);
$surname = $_POST['surname'];
$name = $_POST['name'];


//setting the timeZone
date_default_timezone_set('Europe/Brussels');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM Caregiver WHERE email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$message = "email already in use";
	echo "<script type='text/javascript'>alert('$message'); </script>";

} else if (strcmp($psw, $psw2)) {
	$message = "passwords don't match!";
	echo "<script type='text/javascript'>alert('$message'); </script>";
} else {
	$insert_row = "INSERT INTO Caregiver (idCaregiver, surname, name, email,password) VALUES (NULL,'$surname','$name','$email','$psw')";
	$result = $conn->query($insert_row);
}
$conn->close();



