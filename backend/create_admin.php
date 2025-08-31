<?php
require 'db.php';

// Admin details
$username = 'admin2';
$password = 'qwerty';
$name = 'Jagat Prasad';
$email = 'jagat@example.com';
$phone = '12345678';

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$stmt = $conn->prepare('INSERT INTO admins (username, password, name, email, phone) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('sssss', $username, $hashed_password, $name, $email, $phone);
if ($stmt->execute()) {
    echo "Admin created successfully.";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
?>
