<?php
require 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}
$id = $_GET['id'] ?? 0;
$res = $conn->prepare('SELECT * FROM applications WHERE id=?');
$res->bind_param('i', $id);
$res->execute();
$result = $res->get_result();
$app = $result->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($app);
?>
