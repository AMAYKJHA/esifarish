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
			echo '<!DOCTYPE html><html lang="ne"><head><meta charset="UTF-8"><title>गुनासो दर्ता सफल</title><style>body{background:#ffd6e0;font-family:Segoe UI,Mangal,sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;} .success-box{background:#fff;padding:40px 32px;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,0.13);text-align:center;} .success-box h2{color:#0d6efd;font-size:2rem;margin-bottom:12px;} .success-box p{font-size:1.1rem;color:#444;} .success-box a{display:inline-block;margin-top:24px;background:#0d6efd;color:#fff;padding:12px 32px;border-radius:8px;text-decoration:none;font-weight:600;box-shadow:0 2px 8px rgba(13,110,253,0.10);} .success-box a:hover{background:#084ec7;}</style></head><body><div class="success-box"><span style="font-size:2.5rem;">🎉</span><h2>गुनासो सफलतापूर्वक दर्ता भयो!</h2><p>हामी चाँडै समाधानको प्रयास गर्नेछौं।</p><a href="../backend/nagrikdashboard.php">ड्यासबोर्डमा फर्कनुहोस्</a></div></body></html>';
		} else {
			echo '<!DOCTYPE html><html lang="ne"><head><meta charset="UTF-8"><title>त्रुटि</title></head><body><p style="color:red;text-align:center;font-size:1.2rem;">Error: ' . htmlspecialchars($stmt->error) . '</p></body></html>';
		}
		$stmt->close();
	} else {
		echo 'Please login first.';
	}
}
?>
