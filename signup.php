<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'rentacar';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uname VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo 'Table created successfully.';
} else {
    echo 'Error creating table: ' . $conn->error;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if($pass1==$pass2){
        $sql = "INSERT INTO users (uname, email, password) VALUES ('$uname', '$email', '$pass1')";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            header("Location: user.php");
            exit();
        } else {
            echo 'Error: ' . $sql . '<br>' . $conn->error;
        }
    }else{
        echo 'passwords doesnt match';
    }
}