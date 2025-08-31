<?php
$host = 'localhost';
$user = 'root'; // Change if needed
$pass = '';
$db = 'esifarish'; // Change if needed

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
	die('Database connection failed: ' . $conn->connect_error);
}
?>
