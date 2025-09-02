<?php
// Usage: include this file when admin approves an application
// $applicationId = ... (from GET/POST)
// $message = ... (admin's custom message)
require 'db.php';

// Fetch application details
$applicationId = isset($applicationId) ? $applicationId : ($_GET['id'] ?? null);
if (!$applicationId) { return; }
$stmt = $conn->prepare('SELECT * FROM applications WHERE id = ?');
$stmt->bind_param('i', $applicationId);
$stmt->execute();
$app = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$app) { die('Application not found.'); }

// Load template
// Choose template based on sifarish_type
$type = strtolower($app['sifarish_type']);
$template_map = [
	'birth' => 'birth.html',
	'citizenship' => 'citizenship.html',
	'death' => 'death.html',
	'marriage' => 'marriage.html',
	'poverty' => 'poverty.html'
];
$template_file = $template_map[$type] ?? 'birth.html';
$template = file_get_contents(__DIR__ . '/templates/' . $template_file);
// Replace placeholders with application data
$template = str_replace('{{name_np}}', htmlspecialchars($app['full_name_np']), $template);
$template = str_replace('{{name_en}}', htmlspecialchars($app['full_name_en']), $template);
$template = str_replace('{{dob_bs}}', htmlspecialchars($app['dob_bs']), $template);
$template = str_replace('{{dob_ad}}', htmlspecialchars($app['dob_ad']), $template);
$template = str_replace('{{citizen_no}}', htmlspecialchars($app['citizen_no']), $template);
$template = str_replace('{{message}}', htmlspecialchars($_POST['message'] ?? ''), $template);
// Add more fields as needed

// Save filled template as HTML file
// Debug: Check if uploads folder is writable

$filename = 'certificate_' . $applicationId . '_' . time() . '.html';
$filepath = '../uploads/' . $filename;
file_put_contents($filepath, $template);

// Update application record
if ($conn) {
	$stmt = $conn->prepare('UPDATE applications SET certificate_file = ?, status = "Approved" WHERE id = ?');
	if ($stmt) {
		$stmt->bind_param('si', $filename, $applicationId);
		$stmt->execute();
		$stmt->close();
	}

// Redirect or show success
// If called from AJAX, do not redirect
?>
