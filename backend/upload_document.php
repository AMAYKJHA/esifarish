<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$application_id = $_POST['application_id'] ?? 0;
if (!$application_id || !isset($_FILES['document'])) {
    echo json_encode(['error' => 'Missing data']);
    exit();
}

$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
$fileName = basename($_FILES['document']['name']);
$filePath = $uploadDir . $fileName;
if (move_uploaded_file($_FILES['document']['tmp_name'], $filePath)) {
    // Save filename in applications table
    $stmt = $conn->prepare('UPDATE applications SET certificate_file = ? WHERE id = ?');
    $stmt->bind_param('si', $fileName, $application_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'file' => $fileName]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'File upload failed']);
}
?>
