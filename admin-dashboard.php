<?php
session_start();
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | eSifaris</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f4f6fb;
      margin: 0;
      padding: 0;
    }
    .topbar {
      background: #0d6efd;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 38px 32px 38px 32px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .topbar .logo {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .topbar img {
      width: 60px;
      height: auto;
    }
    .topbar .admin-info {
      font-size: 1.1rem;
      font-weight: 500;
    }
    .topbar .actions {
      display: flex;
      gap: 16px;
    }
    .topbar a {
      background: #28a745;
      color: #fff;
      padding: 8px 18px;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      transition: background 0.2s;
      box-shadow: 0 2px 8px rgba(40,167,69,0.08);
    }
    .topbar a.logout {
      background: #c91f45;
    }
    .topbar a:hover {
      background: #084ec7;
    }
    .dashboard-container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .dashboard-cards {
      display: flex;
      gap: 30px;
      justify-content: center;
      margin-bottom: 40px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(13,110,253,0.08);
      padding: 32px 24px;
      min-width: 220px;
      text-align: center;
      transition: box-shadow 0.2s;
      margin: 0 10px;
    }
    .card:hover {
      box-shadow: 0 8px 24px rgba(13,110,253,0.15);
    }
    .card h2 {
      font-size: 2.2rem;
      margin: 0 0 10px 0;
      color: #0d6efd;
    }
    .card p {
      font-size: 1.1rem;
      color: #333;
      margin: 0;
    }
    .dashboard-links {
      display: flex;
      justify-content: center;
      gap: 24px;
      margin-bottom: 30px;
    }
    .dashboard-links a {
      background: #0d6efd;
      color: #fff;
      padding: 12px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: background 0.2s;
    }
    .dashboard-links a:hover {
      background: #084ec7;
    }
    .welcome {
      text-align: center;
      font-size: 1.2rem;
      color: #444;
      margin-bottom: 20px;
    }
    @media (max-width: 900px) {
      .dashboard-cards {
        flex-direction: column;
        gap: 24px;
        align-items: center;
      }
      .card {
        margin: 0;
        min-width: 180px;
      }
    }
    @media (max-width: 700px) {
      .topbar {
        flex-direction: column;
        align-items: flex-start;
        padding: 18px 12px;
      }
      .dashboard-container {
        padding: 0 8px;
      }
      .dashboard-links {
        flex-direction: column;
        gap: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="topbar">
    <div class="logo">
      <img src="./janakpurdham-logo.png" alt="Janakpurdham Logo" />
      <span style="font-size:1.5rem;font-weight:bold;">Admin Dashboard</span>
    </div>
    <div class="admin-info">Welcome, <?php echo htmlspecialchars($admin_name); ?></div>
    <div class="actions">
      <a href="backend/create_admin.php">➕ Create Admin</a>
      <a href="backend/logout.php" class="logout">🚪 Logout</a>
    </div>
  </div>
  <div class="dashboard-container">
    <div class="dashboard-cards">
      <div class="card">
        <h2 id="totalApps">0</h2>
        <p>Total Applications</p>
      </div>
      <div class="card">
        <h2 id="pendingApps">0</h2>
        <p>Pending</p>
      </div>
      <div class="card">
        <h2 id="approvedApps">0</h2>
        <p>Approved</p>
      </div>
      <div class="card">
        <h2 id="rejectedApps">0</h2>
        <p>Rejected</p>
      </div>
    </div>
    <div class="dashboard-links">
      <a href="backend/applications.php">📄 Applications</a>
      <!-- Add more links here if needed -->
    </div>
    <div class="welcome">
      You can view, approve, or reject sifaris applications.
    </div>
  </div>
  <script>
    // Fetch stats from backend (AJAX)
    fetch('backend/applications_stats.php')
      .then(res => res.json())
      .then(stats => {
        document.getElementById('totalApps').textContent = stats.total;
        document.getElementById('pendingApps').textContent = stats.pending;
        document.getElementById('approvedApps').textContent = stats.approved;
        document.getElementById('rejectedApps').textContent = stats.rejected;
      });
  </script>
</body>
</html>
