<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection parameters
$servername = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbname = 'rentacar';

// Create a connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Retrieve the booked cars data

$sql = "SELECT * FROM cars WHERE status = 'booked'";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
    <link rel="icon" href="carICOo.ico" type="image/x-icon"> 
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 300px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h2>Manage Bookings</h2>
    <p>Logged in as: <?php echo $_SESSION['username']; ?></p>

    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $carId = $row['id'];
            $carName = $row['name'];
            $carStatus = $row['status'];
    ?>
            <div class="card">
                <h3><?php echo $carName; ?></h3>
                <p>Status: <?php echo $carStatus; ?></p>
                <p>Car ID: <?php echo $carId; ?></p>
            </div>
    <?php
        }
    } else {
        echo "No booked cars found.";
    }
    ?>
</body>
</html>
