<?php
// Database connection parameters
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'registration';

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Create cars table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS cars (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    car_name VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    image VARCHAR(100) NOT NULL,
    is_booked TINYINT(1) NOT NULL DEFAULT 0
)";
$conn->query($sql);

// Fetch car data from the database
$carList = [];
$sql = 'SELECT * FROM cars';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $carList[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="icon" href="carICOo.ico" type="image/x-icon"> 
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <h2>Car Management</h2>

    <form method="post" action="added.php">
        <h3>Add Car</h3>
        <label for="car_name">Car Name:</label>
        <input type="text" id="car_name" name="car_name" required>
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>
        <label for="image">Image:</label>
        <input type="text" id="image" name="image" required>
        <input type="submit" value="Add">
    </form>

    <h3>Car List</h3>
    <?php if (count($carList) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Car Name</th>
                    <th>Model</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carList as $car) { ?>
                    <tr>
                        <td><?php echo $car['car_name']; ?></td>
                        <td><?php echo $car['model']; ?></td>
                        <td><img src="<?php echo $car['image']; ?>" alt="Car Image" width="100"></td>
                        <td><?php echo ($car['is_booked'] ? 'Booked' : 'Available'); ?></td>
                        <td>
                            <a href="edit_car.php?id=<?php echo $car['id']; ?>">Edit</a>
                            <a href="delete_car.php?id=<?php echo $car['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No cars found.</p>
    <?php } ?>
</body>
</html>
