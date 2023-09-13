<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

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

// Create the "bookings" table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    rental_time DATETIME NOT NULL,
    return_time DATETIME NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    echo 'Error creating table: ' . $conn->error;
    $conn->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $rentalTime = $_POST['rental_time'];
    $returnTime = $_POST['return_time'];

    // Prepare and execute the SQL statement to save the booking details
    $stmt = $conn->prepare("INSERT INTO bookings (username, address, rental_time, return_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $address, $rentalTime, $returnTime);
    
    if ($stmt->execute()) {
        // Get the ID of the last inserted booking
        $bookingId = $stmt->insert_id;
        
        // Update the car's status to booked
        $carId = $_POST['car_id'];
        $updateStmt = $conn->prepare("UPDATE cars SET status = 'booked' WHERE id = ?");
        $updateStmt->bind_param("i", $carId);
        $updateStmt->execute();
        $updateStmt->close();
        
        $stmt->close();
        $conn->close();
        header("Location: user.php");
        exit();
    } else {
        echo 'Error: ' . $stmt->error;
    }
}

// Close the database connection
$conn->close();
?>
