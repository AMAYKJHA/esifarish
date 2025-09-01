<?php
require 'db.php';
session_start();
// Check if admin is logged in (adjust as per your session logic)
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.html');
    exit();
}
// Fetch all complaints with user details
$sql = "SELECT complaints.*, users.name AS user_name, users.email AS user_email, users.mobile AS user_mobile FROM complaints LEFT JOIN users ON complaints.user_id = users.id ORDER BY complaints.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Complaints</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', 'Mangal', sans-serif;
            background: #ffd6e0;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 30px 20px 20px 20px;
            font-size: 2rem;
            font-weight: bold;
        }
        .header-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .header-actions a {
            background: #fff;
            color: #0d6efd;
            border: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            transition: background 0.2s, color 0.2s;
        }
        .header-actions a:hover {
            background: #0d6efd;
            color: #fff;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        h2 {
            color: #c91f45;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background: #0d6efd;
            color: #fff;
        }
        tr:hover {
            background: #f3f3f3;
        }
        .no-data {
            text-align: center;
            color: #888;
            padding: 30px 0;
        }
    </style>
</head>
<body>
    <header>
        Admin Dashboard
        <div class="header-actions">
            <a href="admin-dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="admin-complaints.php"><i class="fas fa-exclamation-circle"></i> Complaints</a>
        </div>
    </header>
    <div class="container">
        <h2>All Complaints</h2>
        <table>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Citizen ID</th>
                <th>Application ID</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): $i = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['user_email']) ?></td>
                        <td><?= htmlspecialchars($row['user_mobile']) ?></td>
                        <td><?= htmlspecialchars($row['citizen_id']) ?></td>
                        <td><?= htmlspecialchars($row['application_id']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="no-data">No complaints found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
