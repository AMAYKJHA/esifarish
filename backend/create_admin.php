<?php
require 'db.php';
session_start();

// Only allow access if already logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.html');
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $username = $name; // Use name as username

    if ($username && $password && $name && $email && $phone) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO admins (username, password, name, email, phone) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $username, $hashed_password, $name, $email, $phone);
        if ($stmt->execute()) {
            $message = 'Admin created successfully!';
        } else {
            $message = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = 'Please fill all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fb; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 32px; border-radius: 10px; box-shadow: 0 4px 16px rgba(13,110,253,0.08); }
        h2 { text-align: center; color: #0d6efd; }
        label { display: block; margin-top: 16px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-top: 6px; border-radius: 6px; border: 1px solid #ccc; }
        button { margin-top: 24px; width: 100%; background: #0d6efd; color: #fff; border: none; padding: 12px; border-radius: 8px; font-size: 1rem; font-weight: bold; cursor: pointer; }
        button:hover { background: #084ec7; }
        .msg { margin-top: 18px; text-align: center; color: #c91f45; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create New Admin</h2>
        <?php if ($message): ?>
            <div class="msg"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required />
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required />
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required />
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" required />
            <button type="submit">Create Admin</button>
        </form>
    </div>
</body>
</html>
