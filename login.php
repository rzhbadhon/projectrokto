<?php
// login.php
$conn = new mysqli('localhost', 'root', '', 'rokto');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch hashed password from DB
    $stmt = $conn->prepare("
      SELECT seeker_id, password
      FROM seekers
      WHERE username = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['seeker_id'] = $row['seeker_id']; 
            echo "<p style='text-align:center; color:green;'>
                   Login successful! Go to <a href='search.php'>Search Page</a>.
                  </p>";
        } else {
            echo "<p style='text-align:center; color:red;'>Incorrect password.</p>";
        }
    } else {
        echo "<p style='text-align:center; color:red;'>No such user found.</p>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seeker Login</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0; padding: 0;
      background: linear-gradient(to right, #e66465, #9198e5);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      width: 90%;
      max-width: 350px;
      text-align: center;
      animation: fadeIn 0.8s ease-out;
    }
    h1 {
      margin-bottom: 20px;
      font-size: 2em;
      color: #333;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    input, button {
      padding: 12px;
      font-size: 1em;
      border: 2px solid #ddd;
      border-radius: 8px;
      width: 100%;
      outline: none;
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
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 480px) {
      h1 { font-size: 1.8em; }
      input, button { padding: 10px; font-size: 0.9em; }
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Login as Seeker</h1>
    <form method="POST" action="login.php">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
