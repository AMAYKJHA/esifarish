<?php
session_start();
$user_name = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="ne">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>नागरिक ड्यासबोर्ड</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    body {
      font-family: 'Segoe UI', 'Mangal', sans-serif;
      background: linear-gradient(135deg, #f4f6fb 0%, #ffe3ec 100%);
      margin: 0;
      padding: 0;
    }
    .header {
      background: #0d6efd;
      color: #fff;
      text-align: center;
      padding: 36px 0 24px 0;
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
      border-bottom-left-radius: 32px;
      border-bottom-right-radius: 32px;
    }
    .header h1 {
      font-size: 2.5rem;
      margin-bottom: 8px;
    }
    .header p {
      font-size: 1.2rem;
      margin-bottom: 8px;
    }
    .header .user {
      font-size: 1.1rem;
      color: #ffe3ec;
      margin-bottom: 8px;
    }
    .header button {
      background: #fff;
      color: #c91f45;
      border: none;
      padding: 10px 24px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      transition: background 0.2s, color 0.2s;
    }
    .header button:hover {
      background: #c91f45;
      color: #fff;
    }
    .dashboard {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 32px;
      margin-top: 32px;
    }
    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(201,31,69,0.08);
      padding: 32px 20px;
      text-align: center;
      transition: box-shadow 0.2s, transform 0.2s;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    .card:hover {
      box-shadow: 0 8px 32px rgba(13,110,253,0.12);
      transform: translateY(-4px) scale(1.03);
      background: #f9f9ff;
    }
    .card i {
      font-size: 48px;
      color: #c91f45;
      margin-bottom: 12px;
      transition: color 0.2s;
    }
    .card:hover i {
      color: #0d6efd;
    }
    .card h3 {
      font-size: 1.3rem;
      color: #0d6efd;
      margin-bottom: 8px;
    }
    .card p {
      color: #444;
      font-size: 1rem;
      margin-bottom: 12px;
    }
    .dashboard-button {
      display: inline-block;
      margin: 10px 0;
      padding: 10px 18px;
      background-color: #c91f45;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 500;
      transition: background 0.2s;
    }
    .dashboard-button:hover {
      background-color: #0d6efd;
    }
    @media (max-width: 700px) {
      .dashboard-cards {
        grid-template-columns: 1fr;
      }
      .dashboard {
        padding: 0 8px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>नागरिक ड्यासबोर्डमा स्वागत छ</h1>
    <p>यहाँ तपाईंको सिफारिस, डाउनलोड, र इतिहास जानकारी हेर्न सक्नुहुन्छ।</p>
    <div class="user">User: <?php echo htmlspecialchars($user_name); ?></div>
    <button onclick="logout()">लग आउट</button>
  </div>
  <div class="dashboard">
    <div class="dashboard-cards">
      <div class="card" onclick="goTo('apply.html')">
        <i class="fas fa-file-signature"></i>
        <h3>नयाँ सिफारिस</h3>
        <p>नयाँ सिफारिस अनुरोध गर्नुहोस्</p>
      </div>
      <div class="card" onclick="goTo('histroy.html')">
        <i class="fas fa-history"></i>
        <h3>अनुरोध इतिहास</h3>
        <p>अघिल्ला सिफारिस विवरण हेर्नुहोस्</p>
        <a href="history.html" class="dashboard-button">📜 इतिहास हेर्नुहोस्</a>
      </div>
      <div class="card" onclick="goTo('documents.html')">
        <i class="fas fa-download"></i>
        <h3>डाउनलोड</h3>
        <p>एडमिनले अपलोड गरेका सिफारिस पत्र डाउनलोड गर्नुहोस्</p>
        <a href="docs/nata.pdf" download class="dashboard-button">⬇️ नाता प्रमाणपत्र</a>
        <a href="docs/basobas.pdf" download class="dashboard-button">⬇️ बसोबास प्रमाणपत्र</a>
        <a href="docs/junid.pdf" download class="dashboard-button">⬇️ जन्म/मृत्यु प्रमाणपत्र</a>
      </div>
      <div class="card" onclick="goTo('contact.html')">
        <i class="fas fa-phone-alt"></i>
        <h3>सम्पर्क गर्नुहोस्</h3>
        <p>वार्ड कार्यालयसँग सम्पर्क गर्नुहोस्</p>
      </div>
      <div class="card" onclick="goTo('upload-documents.html')">
        <i class="fas fa-upload"></i>
        <h3>कागजात अपलोड</h3>
        <p>आवश्यक कागजातहरू अपलोड गर्नुहोस्</p>
      </div>
      <div class="card" onclick="goTo('status.html')">
        <i class="fas fa-tasks"></i>
        <h3>स्थिति</h3>
        <p>आवेदनको स्थिति ट्र्याक गर्नुहोस्</p>
      </div>
      <div class="card" onclick="goTo('success.html')">
        <i class="fas fa-check-circle"></i>
        <h3>सफलता</h3>
        <p>आवेदन सफल भएमा पृष्ठ हेर्नुहोस्</p>
      </div>
      <div class="card" onclick="goTo('complain.html')">
        <i class="fas fa-exclamation-circle"></i>
        <h3>गुनासो/Complain</h3>
        <p>५ दिनभित्र सिफारिस नपाए वा कुनै जानकारी नआए गुनासो दर्ता गर्नुहोस्</p>
        <a href="complain.html" class="dashboard-button">✍️ गुनासो दर्ता गर्नुहोस्</a>
      </div>
    </div>
  </div>
  <script>
    function logout() {
      window.location.href = "backend/logout.php";
    }
    function goTo(page) {
      window.location.href = page;
    }
  </script>
</body>
</html>
