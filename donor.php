<?php
// donor.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = $_POST['name'];
    $age        = $_POST['age'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $blood_type = $_POST['blood_type'];
    $area       = $_POST['area'];

    $errors = [];
    if (empty($name) || !preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Name must only contain letters and spaces.";
    }
    if (empty($age) || $age < 18) {
        $errors[] = "Age must be 18 or above.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (empty($errors)) {
        $conn = new mysqli('localhost', 'root', '', 'rokto');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("
            INSERT INTO donors
              (name, age, email, phone, blood_type, area)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sissss", $name, $age, $email, $phone, $blood_type, $area);

        if ($stmt->execute()) {
            echo "<p style='color: green; text-align:center;'>Donor details saved successfully.</p>";
        } else {
            echo "<p style='color: red; text-align:center;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red; text-align:center;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register as Donor</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0; padding: 0;
      background: linear-gradient(to right, #e66465, #9198e5);
      min-height: 100vh;
      display: flex;
      justify-content: center;
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
    input, select, button {
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
    @media (max-width: 480px) {
      h1 { font-size: 1.8em; }
      input, select, button { padding: 10px; font-size: 0.9em; }
    }
  </style>
</head>
<body>
  <div class="box-container">
    <h1>Register as Donor</h1>
    <form method="POST" action="donor.php">
      <input type="text" name="name" placeholder="Name" required>
      <input type="number" name="age" placeholder="Age (≥18)" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="phone" placeholder="Phone" required>
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
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
