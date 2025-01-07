
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blood_type = $_POST['blood_type'];
    $area = $_POST['area'];

    $conn = new mysqli('localhost', 'root', '', 'rokto');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT name, phone, rating FROM donor WHERE blood_type = ? AND area = ?");
    $stmt->bind_param("ss", $blood_type, $area);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1>Donors Available</h1>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='donor-card'>";
            echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
            echo "<p><strong>Phone:</strong> " . $row['phone'] . "</p>";
            echo "<p><strong>Rating:</strong> " . $row['rating'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-donor'>Sorry, there is no donor available in this area.</p>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for Blood</title>
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #f53d4e, #8f2332, #8f0005);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.box-container {
    background: linear-gradient(135deg, #fff, #f8f9fa);
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    width: 90%;
    max-width: 400px;
    padding: 30px;
    text-align: center;
    animation: fadeIn 0.8s ease-out;
}

h1 {
    margin-bottom: 20px;
    font-size: 1.8em;
    color:rgb(79, 45, 45);
    font-weight: 600;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-size: 0.9em;
    color: #555;
    text-align: left;
}

select, button {
    padding: 12px;
    font-size: 1em;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    width: 100%;
    outline: none;
    transition: all 0.3s ease;
}

select {
    background-color: #f9f9f9;
}

select:focus {
    border-color: #6c63ff;
}

button {
    background: #ff4b5c;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: 600;
    margin-top: 10px;
}

button:hover {
    background: #d43c4c;
    transform: scale(1.05);
}

.donor-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin: 10px 0;
    text-align: left;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.donor-card p {
    margin: 5px 0;
    color: #333;
}

.no-donor {
    color: #ff4b5c;
    font-weight: 500;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
 100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 600px) {
    .box-container {
        width: 95%;
        padding: 20px;
    }

    h1 {
        font-size: 1.5em;
    }

    button {
        padding: 10px;
    }
}
    </style>
</head>
<body>
    <div class="box-container">
        <h1>I'm Looking for Blood</h1>
        <form method="POST" action="search.php">
            <label>Blood Type:
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
            </label>
            <label>Area:
                <select name="area" required>
                    <option value="Bashundhara">Bashundhara</option>
                    <option value="Vatara">Vatara</option>
                    <option value="Uttara">Uttara</option>
                    <option value="Mirpur">Mirpur</option>
                    <option value="Dhanmondi">Dhanmondi</option>
                    <option value="Rampura">Rampura</option>
                </select>
            </label>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>