<?php
session_start();

// Database connection parameters
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'rentacar';

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['uname'];
    $pass = $_POST['pass1'];

    // Prepare and execute the SQL statement to check user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE uname = ? AND password = ?");
    $stmt->bind_param("ss", $uname, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, login successful
        $_SESSION['username'] = $uname; // Store username in session
        $stmt->close();
        $conn->close();
        header("Location: user.php");
        exit();
    } else {
        // User not found or invalid credentials
        echo 'Invalid username or password.';
    }
}

// Close the database connection
$conn->close();
?>
