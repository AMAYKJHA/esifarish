<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user_id = $_SESSION['user_id'] ?? null;
	$name = $_POST['name'] ?? '';
	$citizen_id = $_POST['citizenId'] ?? '';
	$application_id = $_POST['applicationId'] ?? '';
	$message = $_POST['message'] ?? '';

	if ($user_id) {
		$stmt = $conn->prepare('INSERT INTO complaints (user_id, citizen_id, application_id, message) VALUES (?, ?, ?, ?)');
		$stmt->bind_param('isss', $user_id, $citizen_id, $application_id, $message);
		if ($stmt->execute()) {
			echo 'Complaint submitted.';
		} else {
			echo 'Error: ' . $stmt->error;
		}
		$stmt->close();
	} else {
		echo 'Please login first.';
	}
}
?>
