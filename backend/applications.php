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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <style>
            body {
                background: #ffd6e0;
                font-family: 'Segoe UI', 'Mangal', sans-serif;
                margin: 0;
                padding: 0;
            }
            .header {
                background: #0d6efd;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 24px 32px;
                box-shadow: 0 2px 12px rgba(0,0,0,0.08);
                border-bottom-left-radius: 32px;
                border-bottom-right-radius: 32px;
                margin-bottom: 0;
            }
            .header-actions {
                display: flex;
                gap: 14px;
            }
            .header-actions a {
                background: #0d6efd;
                color: #fff;
                padding: 10px 24px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 600;
                font-size: 16px;
                box-shadow: 0 2px 8px rgba(13,110,253,0.10);
                transition: background 0.2s, transform 0.2s;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .header-actions a.logout {
                background: #c91f45;
            }
            .header-actions a:hover {
                background: #084ec7;
                transform: translateY(-2px) scale(1.04);
            }
            .header-actions a.logout:hover {
                background: #a51835;
            }
            .container {
                max-width: 1100px;
                margin: 40px auto;
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 4px 16px rgba(13,110,253,0.08);
                padding: 32px 24px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 24px;
                background: #f8fbff;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(13,110,253,0.05);
            }
            th, td {
                padding: 12px 10px;
                border: 1px solid #cce3ff;
                text-align: left;
            }
            th {
                background-color: #eaf3ff;
                color: #0d6efd;
                font-size: 17px;
            }
            .btn {
                padding: 8px 18px;
                margin-right: 5px;
                cursor: pointer;
                border: none;
                border-radius: 8px;
                font-size: 15px;
                font-weight: 500;
                box-shadow: 0 2px 8px rgba(13,110,253,0.08);
                transition: background 0.2s;
            }
            .approve {
                background-color: #4CAF50;
                color: white;
            }
            .reject {
                background-color: #f44336;
                color: white;
            }
            .view {
                background-color: #0d6efd;
                color: white;
            }
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                padding-top: 100px;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.6);
            }
            .modal-content {
                background-color: #fff;
                margin: auto;
                padding: 32px 24px;
                border-radius: 12px;
                width: 60%;
                box-shadow: 0 4px 16px rgba(13,110,253,0.12);
            }
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }
            .modal-content h3 {
                color: #0d6efd;
            }
        </style>
<body>
            <div class="header">
                <div style="display: flex; align-items: center; gap: 18px;">
                    <img src="../janakpurdham-logo.png" alt="Janakpurdham Logo" style="height: 54px; border-radius: 8px; box-shadow: 0 2px 8px rgba(13,110,253,0.08);" />
                    <span style="font-size: 2rem; font-weight: bold; letter-spacing: 1px;">🗂️ Applications</span>
                </div>
                <div class="header-actions">
                    <a href="admin-dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                    <a href="applications.php"><i class="fas fa-file-alt"></i> Applications</a>
                    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
    <div class="container">
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
                            <td style="vertical-align: top;">
                                <div style="display: flex; flex-direction: column; gap: 8px; min-width: 220px;">
                                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                        <button class="btn approve" onclick="updateStatus(<?php echo $row['id']; ?>, 'Approved')">Approve</button>
                                        <button class="btn reject" onclick="updateStatus(<?php echo $row['id']; ?>, 'Rejected')">Reject</button>
                                        <button class="btn view" onclick="openModal(<?php echo $row['id']; ?>)">View</button>
                                    </div>
                                    <form enctype="multipart/form-data" onsubmit="uploadDocument(event, <?php echo $row['id']; ?>)" style="display: flex; gap: 6px; align-items: center; margin-top: 4px;">
                                        <input type="file" name="document" required style="width: 140px;" />
                                        <button type="submit" class="btn" style="background:#0d6efd;color:#fff;">Upload</button>
                                    </form>
                                    <?php if (!empty($row['certificate_file'])): ?>
                                        <a href="../uploads/<?php echo htmlspecialchars($row['certificate_file']); ?>" target="_blank" style="margin-top:4px; color:#0d6efd;">Download</a>
                                    <?php endif; ?>
                                </div>
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
    </div>
    <script>
    function uploadDocument(e, appId) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);
        formData.append('application_id', appId);
        fetch('upload_document.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('File uploaded!');
                location.reload();
            } else {
                alert('Upload failed: ' + (data.error || 'Unknown error'));
            }
        });
    }
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
            fetch('update_application_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + id + '&status=' + status
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
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
