<?php
require 'db.php';
session_start();

// Only allow access if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$stats = [
    'total' => 0,
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
];

$res = $conn->query("SELECT status, COUNT(*) as cnt FROM applications GROUP BY status");
while ($row = $res->fetch_assoc()) {
    $stats['total'] += $row['cnt'];
    if ($row['status'] === 'Pending') $stats['pending'] = $row['cnt'];
    if ($row['status'] === 'Approved') $stats['approved'] = $row['cnt'];
    if ($row['status'] === 'Rejected') $stats['rejected'] = $row['cnt'];
}

header('Content-Type: application/json');
echo json_encode($stats);
?>
