
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_type = $_POST['blood_type'];
    $area = $_POST['area'];

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
        $stmt = $conn->prepare("INSERT INTO donor (name, age, email, phone, blood_type, area) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $name, $age, $email, $phone, $blood_type, $area);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Donor details successfully saved.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
        $conn->close();
    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Donor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background: linear-gradient(135deg, #f53d4e, #8f2332, #8f0005);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box-container {
            background: linear-gradient(135deg, #fff, #f8f9fa);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 350px;
            padding: 30px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        h1 {
            margin: 0 0 10px;
            font-size: 2em;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        input, select, button {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 80%;
        }
        button {
            background-color: #ff4b5c;
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #d43c4c;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="box-container">
        <h1>Become a Donor</h1>
        <form method="POST" action="donor.php">
            <input type="text" name="name" placeholder="Name" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <select name="blood_type" required>
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
