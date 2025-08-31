<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard | eSifaris</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f4f6fb;
        margin: 0;
        padding: 0;
      }
      .header {
        background: #0d6efd;
        color: #fff;
        padding: 24px 0 16px 0;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      }
      .header img {
        width: 120px;
        margin-bottom: 10px;
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
        box-shadow: 0 4px 16px rgba(13, 110, 253, 0.08);
        padding: 32px 24px;
        min-width: 220px;
        text-align: center;
        transition: box-shadow 0.2s;
      }
      .card:hover {
        box-shadow: 0 8px 24px rgba(13, 110, 253, 0.15);
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
    </style>
  </head>
  <body>
    <div class="header">
      <img src="./janakpurdham-logo.png" alt="Janakpurdham Logo" />
      <h1>Admin Dashboard</h1>
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
        <a href="backend/logout.php">🚪 Logout</a>
      </div>
      <div class="welcome">
        <?php
        session_start();
        $admin_name = $_SESSION['admin_name'] ?? 'Admin';
        ?>
        Welcome,
        <?php echo htmlspecialchars($admin_name); ?>. You can view, approve, or
        reject sifaris applications.
      </div>
    </div>
    <script>
      // Fetch stats from backend (AJAX)
      fetch("backend/applications_stats.php")
        .then((res) => res.json())
        .then((stats) => {
          document.getElementById("totalApps").textContent = stats.total;
          document.getElementById("pendingApps").textContent = stats.pending;
          document.getElementById("approvedApps").textContent = stats.approved;
          document.getElementById("rejectedApps").textContent = stats.rejected;
        });
    </script>
  </body>
</html>
