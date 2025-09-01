<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$input = $_POST['input'] ?? '';
	$password = $_POST['password'] ?? '';

	$stmt = $conn->prepare('SELECT * FROM users WHERE email=? OR mobile=? OR name=?');
	$stmt->bind_param('sss', $input, $input, $input);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_assoc();

	if ($user && password_verify($password, $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['user_name'] = $user['name'];
		// Redirect to nagrikdashboard.php after successful login
		header('Location: nagrikdashboard.php');
		exit();
	} else {
		echo 'Invalid credentials.';
	}
	$stmt->close();
}
?>
