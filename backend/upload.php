<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
	$user_id = $_SESSION['user_id'] ?? null;
	if ($user_id) {
		$file = $_FILES['document'];
		$target_dir = 'uploads/';
		if (!is_dir($target_dir)) {
			mkdir($target_dir);
		}
		$target_file = $target_dir . basename($file['name']);
		if (move_uploaded_file($file['tmp_name'], $target_file)) {
			$stmt = $conn->prepare('INSERT INTO documents (user_id, file_name, file_path) VALUES (?, ?, ?)');
			$stmt->bind_param('iss', $user_id, $file['name'], $target_file);
			if ($stmt->execute()) {
				echo 'File uploaded.';
			} else {
				echo 'Error: ' . $stmt->error;
			}
			$stmt->close();
		} else {
			echo 'File upload failed.';
		}
	} else {
		echo 'Please login first.';
	}
}
?>
