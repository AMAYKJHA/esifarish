<?php
require 'db.php';
session_start();

// Optional: Only allow access if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin-login.html');
    exit();
}

$result = $conn->query('SELECT * FROM applications ORDER BY submitted_at DESC');
?>
<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <title>Citizen Applications</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f0f0f0; }
        .btn { padding: 5px 10px; margin-right: 5px; cursor: pointer; border: none; border-radius: 4px; }
        .approve { background-color: #4CAF50; color: white; }
        .reject { background-color: #f44336; color: white; }
        .view { background-color: #2196F3; color: white; }
        .modal { display: none; position: fixed; z-index: 1000; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); }
        .modal-content { background-color: white; margin: auto; padding: 20px; border-radius: 6px; width: 60%; }
        .close { color: #aaa; float: right; font-size: 24px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <h2>📋 eSifaris Dashboard</h2>
    <nav>
      <a href="../admin-dashboard.html">🏠 Dashboard</a> |
      <a href="applications.php">📄 Applications</a> |
      <a href="logout.php">🚪 Logout</a>
    </nav>
    <table>
        <tr>
            <th>नाम</th>
            <th>सिफारिस प्रकार</th>
            <th>मिति</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr id="row-<?php echo $row['id']; ?>">
            <td><?php echo htmlspecialchars($row['full_name_np']); ?></td>
            <td><?php echo htmlspecialchars($row['sifarish_type']); ?></td>
            <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
            <td id="status-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <button class="btn approve" onclick="updateStatus(<?php echo $row['id']; ?>, 'Approved')">Approve</button>
                <button class="btn reject" onclick="updateStatus(<?php echo $row['id']; ?>, 'Rejected')">Reject</button>
                <button class="btn view" onclick="openModal(<?php echo $row['id']; ?>)">View</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>आवेदक विवरण</h3>
            <div id="modalDetails">
              <p>Loading...</p>
            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            document.getElementById("viewModal").style.display = "block";
            document.getElementById("modalDetails").innerHTML = "<p>Loading...</p>";
            fetch('application_details.php?id=' + id)
              .then(res => res.json())
              .then(app => {
                if (app && !app.error) {
                  let html = `<p><strong>नाम:</strong> ${app.full_name_np}</p>`;
                  html += `<p><strong>सिफारिस प्रकार:</strong> ${app.sifarish_type}</p>`;
                  html += `<p><strong>मिति:</strong> ${app.submitted_at}</p>`;
                  html += `<p><strong>मोबाइल:</strong> ${app.mobile_no}</p>`;
                  html += `<p><strong>जिल्ला:</strong> ${app.district_id}</p>`;
                  html += `<p><strong>Status:</strong> ${app.status}</p>`;
                  html += `<p><strong>Citizenship Front:</strong> <a href="${app.citizenship_front}" target="_blank">Download</a></p>`;
                  html += `<p><strong>Citizenship Back:</strong> <a href="${app.citizenship_back}" target="_blank">Download</a></p>`;
                  document.getElementById("modalDetails").innerHTML = html;
                } else {
                  document.getElementById("modalDetails").innerHTML = "<p>Error loading details.</p>";
                }
              });
        }
        function closeModal() {
            document.getElementById("viewModal").style.display = "none";
        }
        function updateStatus(id, status) {
            var approveBtn = document.querySelector('#row-' + id + ' .approve');
            var rejectBtn = document.querySelector('#row-' + id + ' .reject');
            approveBtn.disabled = true;
            rejectBtn.disabled = true;
            approveBtn.textContent = 'Processing...';
            rejectBtn.textContent = 'Processing...';
            fetch('update_application_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + id + '&status=' + status
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('status-' + id).textContent = status;
                    if (status === 'Approved') {
                        approveBtn.textContent = 'Approved';
                        approveBtn.style.backgroundColor = '#4CAF50';
                        rejectBtn.textContent = 'Reject';
                        rejectBtn.disabled = false;
                    } else {
                        rejectBtn.textContent = 'Rejected';
                        rejectBtn.style.backgroundColor = '#f44336';
                        approveBtn.textContent = 'Approve';
                        approveBtn.disabled = false;
                    }
                } else {
                    alert('Failed to update status');
                    approveBtn.textContent = 'Approve';
                    rejectBtn.textContent = 'Reject';
                    approveBtn.disabled = false;
                    rejectBtn.disabled = false;
                }
            });
        }
        window.onclick = function(event) {
            const modal = document.getElementById("viewModal");
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
