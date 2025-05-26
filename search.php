<?php
// search.php (logs each search, then shows donors)
// 1) Start session (optional if you later want to show seeker name)
session_start();

// 2) Handle form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blood_type = $_POST['blood_type'];
    $area       = $_POST['area'];
    $seeker_id  = isset($_SESSION['username']) ? $_SESSION['seeker_id'] : NULL;

    // Insert into requests table
    $conn = new mysqli('localhost', 'root', '', 'rokto');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("
      INSERT INTO requests (seeker_id, blood_type, area)
      VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iss", $seeker_id, $blood_type, $area);
    $stmt->execute();
    $stmt->close();

    // Now fetch matching donors
    $stmt2 = $conn->prepare("
      SELECT name, phone, blood_type, area
      FROM donors
      WHERE blood_type = ? AND area = ?
        AND status = 'available'
    ");
    $stmt2->bind_param("ss", $blood_type, $area);
    $stmt2->execute();
    $result = $stmt2->get_result();

    // Prepare a simple HTML block for display
    if ($result->num_rows > 0) {
        $donors_html = "<h2 style='color:#333;'>Donors Available:</h2>";
        while ($row = $result->fetch_assoc()) {
            $donors_html .= "
              <div style='border-bottom:1px solid #ddd; margin:10px 0; padding:10px;'>
                <p><strong>Name:</strong> {$row['name']}</p>
                <p><strong>Phone:</strong> {$row['phone']}</p>
                <p><strong>Blood Type:</strong> {$row['blood_type']}</p>
                <p><strong>Area:</strong> {$row['area']}</p>
              </div>
            ";
        }
    } else {
        $donors_html = "<p style='color:red;'>Sorry, no donors available in this area.</p>";
    }

    $stmt2->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Find Blood</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0; padding: 0;
      text-align: center;
      background: linear-gradient(to right, #e66465, #9198e5);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .box-container {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      width: 90%;
      max-width: 400px;
      padding: 30px;
      text-align: center;
      margin-top: 40px;
      animation: slideDown 0.8s ease-out;
    }
    h1 {
      margin-bottom: 20px;
      font-size: 2.2em;
      color: #333333;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    select, button {
      padding: 12px;
      font-size: 1em;
      border: 2px solid #ddd;
      border-radius: 8px;
      width: 100%;
      outline: none;
    }
    select {
      background-color: #f9f9f9;
      transition: border-color 0.3s;
    }
    select:focus {
      border-color: #9198e5;
    }
    button {
      background-color: #e66465;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s;
    }
    button:hover {
      background-color: #c0525a;
      transform: translateY(-2px);
    }
    .links {
      margin-top: 15px;
    }
    .links a {
      color: #e66465;
      text-decoration: none;
      font-weight: bold;
      margin: 0 10px;
    }
    .links a:hover {
      text-decoration: underline;
    }
    @keyframes slideDown {
      0% {
        opacity: 0;
        transform: translateY(-30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    /* Results area styling */
    .results {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 90%;
      max-width: 400px;
      margin: 20px auto;
      padding: 20px;
      text-align: left;
      color: #333;
    }
    @media (max-width: 480px) {
      h1 { font-size: 1.8em; }
      select, button { padding: 10px; font-size: 0.9em; }
    }
  </style>
</head>
<body>
  <div class="box-container">
    <h1>Find Blood</h1>
    <form method="POST" action="search.php">
      <select name="blood_type" required>
        <option value="">Select Blood Type</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>
      <select name="area" required>
        <option value="">Select Area</option>
        <option value="Bashundhara">Bashundhara</option>
        <option value="Vatara">Vatara</option>
        <option value="Uttara">Uttara</option>
        <option value="Mirpur">Mirpur</option>
        <option value="Dhanmondi">Dhanmondi</option>
        <option value="Rampura">Rampura</option>
      </select>
      <button type="submit">Search</button>
    </form>
    <div class="links">
      <a href="register.php">Register</a> |
      <a href="login.php">Login</a>
    </div>
  </div>

  <?php
  // If a search was performed, display results here:
  if (isset($donors_html)) {
      echo "<div class=\"results\">$donors_html</div>";
  }
  ?>
</body>
</html>
