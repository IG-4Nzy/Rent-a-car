<?php
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

// Create the "cars" table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_name VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    image VARBINARY(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'AVAILABLE'
)";

if ($conn->query($sql) === TRUE) {
    echo 'Table created successfully.';
} else {
    echo 'Error creating table: ' . $conn->error;
}

// Fetch car data from the database
$carList = [];
$sql = 'SELECT * FROM cars';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $carList[] = $row;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $car_name = $_POST['car_name'];
    $model = $_POST['model'];
    $image = $_POST['image'];
    $price = $_POST['price'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO cars (car_name, model, image, price) VALUES ('$car_name', '$model', '$image', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo 'Car added successfully.';
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }
}

// Delete car
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute the SQL statement
    $sql = "DELETE FROM cars WHERE id = '$delete_id'";

    if ($conn->query($sql) === TRUE) {
        echo 'Car deleted successfully.';
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
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
        /* CSS styles for car cards */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 300px;
            margin: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .card h4 {
            margin: 0;
        }

        .card p {
            margin: 0;
            margin-bottom: 10px;
        }

        .card .status {
            font-weight: bold;
        }

        .card .actions {
            margin-top: 10px;
        }

        .card .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #333;
            background-color: #f1f1f1;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .card .actions a:hover {
            background-color: #e0e0e0;
        }
        .addcar{
            position: relative;
            left:500px;
            border-radius:30px;
            border-width:2px;
            border-style:solid;
            border-color:green;
            height:300px;
            width:300px;
            align-items:center;
            display:block;
            background-color:lightgreen;
        }
        .cname,.cmodel,.cimage,.cprice{
            position: relative;
            left:50px;
            border-radius:5px;
            width:200px;
            height:30px;
        }
        .lname,.lmodel,.limage,.lprice{
            position: relative;
            left:50px;
        }
        .csubmit{
            position: relative;
            left:120px;
            top:5px;
            background-color:lightblue;
        }
        .csubmit:hover{
            background-color:hotpink;
        }
        .ac{
            position:relative;
            left:110px;
        }
        .cname:hover,.cmodel:hover,.cimage:hover,.cprice:hover{
            border-color:green;
        }
    </style>
</head>
<body>
    <h2 style="position:relative;left:550px;" >Car Management</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class=addcar>
        <h3 class="ac">Add Car</h3>
        <label class="lname" for="car_name">Car Name:</label><br>
        <input class="cname"  type="text" id="car_name" name="car_name" required><br>
        <label class="lname" for="model">Model:</label><br>
        <input class="cmodel"  type="text" id="model" name="model" required><br>
        <label class="lname" for="image">Image:</label><br>
        <input class="cimage"  type="file" id="image" name="image" required><br>
        <label class="lname" for="price">Price:</label><br>
        <input class="cprice"  type="number" id="price" name="price" required><br>
        <input class="csubmit"  type="submit" value="Add"><br>
        <a style="position:relative;left:200px;bottom:10px;"href="admin.html">BACK</a>
    </div>
    </form>

    <h3 style="position:relative;left:600px;">Car List</h3>
    <div class="card-container">
        <?php if (count($carList) > 0) { ?>
            <?php foreach ($carList as $car) { ?>
                <div class="card">
                    <img src="<?php echo $car['image']; ?>" alt="Car Image">
                    <h4><?php echo $car['car_name']; ?></h4>
                    <p>Model: <?php echo $car['model']; ?></p>
                    <p>Price: <?php echo $car['price']; ?></p>
                    <div class="actions">
                        <a href="edit_car.php?id=<?php echo $car['id']; ?>">Edit</a>
                        <a href="?delete_id=<?php echo $car['id']; ?>">Delete</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No cars found.</p>
        <?php } ?>
    </div>
</body>
</html>
