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

$email = $_POST['email'];
$psw_dec = $_POST['psw'];
$psw = md5($psw_dec);
$psw2 = md5($_POST['psw2']);
$surname = $_POST['firstname'];
$name = $_POST['lastname'];


$sql = "SELECT * FROM Caregiver WHERE email = '$email'";
$result = $dbh->query($sql);

if ($result->rowCount() > 0) {
	$message = "email already in use";
	echo "<script type='text/javascript'>alert('$message'); </script>";

} else if (strcmp($psw, $psw2)) {
	$message = "passwords don't match!";
	echo "<script type='text/javascript'>alert('$message'); </script>";
} else {
	$insert_row = "INSERT INTO Caregiver (idCaregiver, firstname, lastname, email, floor, password, created, modified, status) VALUES (NULL,'$surname','$name','$email','101','$psw',CURRENT_TIME ,CURRENT_TIME,'0')";
	$result = $dbh->exec($insert_row);
	print $result;
}

$dbh = null;

?>

