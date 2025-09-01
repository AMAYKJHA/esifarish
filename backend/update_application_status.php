<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}
$id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';
if (!in_array($status, ['Approved', 'Rejected'])) {
    echo json_encode(['error' => 'Invalid status']);
    exit();
}
$stmt = $conn->prepare('UPDATE applications SET status=? WHERE id=?');
$stmt->bind_param('si', $status, $id);
if ($stmt->execute()) {
    if ($status === 'Approved') {
        // Generate certificate for this application
        include_once 'generate_certificate.php';
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Update failed']);
}
$stmt->close();

    if ($status === 'Rejected') {
        $stmt = $conn->prepare('UPDATE applications SET status=? WHERE id=?');
        $stmt->bind_param('si', $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Update failed']);
        }
        $stmt->close();
    } elseif ($status === 'Approved') {
        $applicationId = $id;
        ob_start();
        include_once 'generate_certificate.php';
        ob_end_clean();
        echo json_encode(['success' => true]);
        exit();
    }
?>
