<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo '<p style="color:red;text-align:center;font-size:1.2rem;">कृपया पहिले लग-इन गर्नुहोस्।</p>';
    exit();
}

$sql = "SELECT id, sifarish_type, submitted_at, status, certificate_file FROM applications WHERE user_id = ? ORDER BY submitted_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ne">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>सिफारिस इतिहास</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    body { font-family: 'Mangal', sans-serif; background: rgb(255, 202, 219); margin: 0; padding: 0; }
    header { background-color: #0d6efd; color: white; text-align: center; padding: 20px; }
    .container { max-width: 900px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    h2 { color: #c91f45; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 12px; text-align: center; }
    th { background-color: #c91f45; color: #fff; }
    .status-pending { color: orange; font-weight: bold; }
    .status-approved { color: green; font-weight: bold; }
    .status-rejected { color: red; font-weight: bold; }
    .dashboard-btn { display:inline-block; margin-top:24px; background:#0d6efd; color:#fff; padding:10px 24px; border-radius:8px; text-decoration:none; font-weight:600; box-shadow:0 2px 8px rgba(13,110,253,0.10); }
    .dashboard-btn:hover { background:#084ec7; }
  </style>
</head>
<body>
  <header>
    <h1>सिफारिस इतिहास</h1>
    <p>यहाँ तपाईँले वार्ड कार्यालयबाट पाएको अघिल्ला सिफारिस विवरण हेर्न सक्नुहुन्छ।</p>
  </header>
  <div class="container">
    <h2><i class="fas fa-history"></i> अघिल्ला सिफारिस विवरण</h2>
    <table>
      <thead>
        <tr>
          <th>आवेदन नं</th>
          <th>सिफारिस प्रकार</th>
          <th>पेश गरेको मिति</th>
          <th>स्थिति</th>
          <th>डाउनलोड</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['sifarish_type']) ?></td>
              <td><?= htmlspecialchars($row['submitted_at']) ?></td>
              <td class="status-<?= strtolower($row['status']) ?>">
                <?php
                  if ($row['status'] === 'Pending') echo 'प्रक्रियामा';
                  elseif ($row['status'] === 'Approved') echo 'स्वीकृत';
                  elseif ($row['status'] === 'Rejected') echo 'अस्वीकृत';
                  else echo htmlspecialchars($row['status']);
                ?>
              </td>
              <td>
                <?php if (!empty($row['certificate_file']) && $row['status'] === 'Approved'): ?>
                  <a href="../uploads/<?= htmlspecialchars($row['certificate_file']) ?>" download>⬇️ डाउनलोड</a>
                <?php else: ?>
                  -
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5">कुनै आवेदन फेला परेन।</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    <a href="nagrikdashboard.php" class="dashboard-btn">ड्यासबोर्डमा फर्कनुहोस्</a>
  </div>
</body>
</html>
<?php $stmt->close(); ?>
