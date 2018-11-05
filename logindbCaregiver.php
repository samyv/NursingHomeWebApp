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

$email = $_POST['email'];
$pass = md5($_POST['psw']);

echo $email;
echo $pass;

$sql = "SELECT * FROM Caregiver WHERE email = '$email' AND password = '$pass'";
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
