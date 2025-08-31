<?php
session_start();
$user_name = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="ne">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>eSifaris Dashboard</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<style>
.dashboard {
  padding: 20px;
  max-width: 1200px;
  max-height: 500px;
  margin: auto;
}
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.dashboard-header h2 {
  color: #c91f45;
}
.dashboard-header button {
  background-color: #c91f45;
  color: #fff;
  border: none;
  padding: 10px 16px;
  cursor: pointer;
  border-radius: 6px;
}
.dashboard-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-top: 30px;
}
.card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  transition: transform 0.2s;
  cursor: pointer;
}
.card:hover {
  transform: translateY(-5px);
}
.card i {
  font-size: 40px;
  color: #c91f45;
  margin-bottom: 10px;
}
.dashboard-button {
  display: inline-block;
  margin: 10px 0;
  padding: 10px 16px;
  background-color: #c91f45;
  color: #fff;
  text-decoration: none;
  border-radius: 8px;
  font-size: 14px;
}
.dashboard-button:hover {
  background-color: #a51835;
}  
body {
  font-family: 'Mangal', sans-serif;
  background: rgb(255, 202, 219);
  margin: 0;
  padding: 0;
}
header {
  background-color: #0d6efd;
  color: white;
  text-align: center;
  padding: 20px 0;
}
</style>
<body>
  <div class="dashboard">
    <header class="dashboard-header">
        <h1>नागरिक ड्यासबोर्डमा स्वागत छ</h1>
        <p>यहाँ तपाईंको सिफारिस, डाउनलोड, र इतिहास जानकारी हेर्न सक्नुहुन्छ।</p>
        <h3 style="color:#c91f45;">नाम: <?php echo htmlspecialchars($user_name); ?></h3>
        <button onclick="logout()">लग आउट</button>
    </header>
    <div class="dashboard-cards">
      <!-- ...existing dashboard cards from nagrikdashboard.html... -->
      <div class="card" onclick="goTo('apply.html')">
        <i class="fas fa-file-signature"></i>
        <h3>नयाँ सिफारिस</h3>
        <p>नयाँ सिफारिस अनुरोध गर्नुहोस्</p>
      </div>
      <div class="card" onclick="goTo('histroy.html')">
        <i class="fas fa-history"></i>
        <h3>अनुरोध इतिहास</h3>
        <p>तपाईँले कार्यालयबाट पाएको अघिल्ला सिफारिस विवरण हेर्नुहोस्</p>
        <a href="history.html" class="dashboard-button">📜 इतिहास हेर्नुहोस्</a>
      </div>
      <div class="card" onclick="goTo('documents.html')">
        <i class="fas fa-download"></i>
        <h3>डाउनलोड</h3>
        <p>एडमिनले अपलोड गरेका सिफारिस पत्र यहाँबाट डाउनलोड गर्नुहोस्</p>
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
    localStorage.removeItem("user");
    window.location.href = "login.html";
  }
  function goTo(page) {
    window.location.href = page;
  }
</script>
</body>
</html>
