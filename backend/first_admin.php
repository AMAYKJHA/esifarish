<?php
require 'db.php';
// Create a default admin user
$name = 'admin';
$username = 'first admin';
$password = 'qwerty';
$email = 'admin@gmail.com';
$phone = '12345678';
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare('INSERT INTO admins (name, username, password, email, phone) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('sssss', $name, $username, $hash, $email, $phone);
if ($stmt->execute()) {
    echo 'Admin created successfully.';
} else {
    echo 'Error: ' . $stmt->error;
}
$stmt->close();
?>