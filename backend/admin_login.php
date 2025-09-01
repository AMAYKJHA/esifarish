<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare('SELECT * FROM admins WHERE phone=?');
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin) {
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header('Location: admin-dashboard.php');
            exit();
        } else {
            echo 'Invalid password.';
        }
    } else {
        echo 'Invalid admin credentials.';
    }
    $stmt->close();
}
?>
