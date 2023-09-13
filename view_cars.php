<?php
// Assuming you have a database connection established
// You may need to modify the connection details according to your setup

// Example database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "rentacar";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the added cars from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Delete car if requested
if (isset($_POST['delete'])) {
    $carId = $_POST['delete'];
    $deleteSql = "DELETE FROM cars WHERE id = '$carId'";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Car deleted successfully!";
    } else {
        echo "Error deleting car: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Cars</title>
    <link rel="icon" href="carICOo.ico" type="image/x-icon"> 
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .delete-button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>View Cars</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Car Name</th>
            <th>Manufacturer</th>
            <th>Actions</th>
        </tr>
        <?php
        // Display the cars in a table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $carId = $row["id"];
                $carName = $row["car_name"];
                $manufacturer = $row["manufacturer"];
                echo "<tr>";
                echo "<td>$carId</td>";
                echo "<td>$carName</td>";
                echo "<td>$manufacturer</td>";
                echo "<td><form method='post' action='view_cars.php'><button class='delete-button' type='submit' name='delete' value='$carId'>Delete</button></form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No cars found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
