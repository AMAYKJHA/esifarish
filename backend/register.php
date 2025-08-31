<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'] ?? '';
	$mobile = $_POST['mobile'] ?? '';
	$email = $_POST['email'] ?? '';
	$password = $_POST['password'] ?? '';
	$hash = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $conn->prepare('INSERT INTO users (name, mobile, email, password) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('ssss', $name, $mobile, $email, $hash);
	if ($stmt->execute()) {
		echo 'Registration successful.';
	} else {
		echo 'Error: ' . $stmt->error;
	}
	$stmt->close();
}
?>
