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
    <title>Car Rental</title>
    <link rel="icon" href="carICOo.ico" type="image/x-icon"> 
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
        }

        .card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .card h4 {
            margin-top: 10px;
        }

        .card p {
            margin: 5px 0;
        }

        .book-now {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Car Rental</h2>

    <div class="card-container">
        <a style="text-align:center;padding:5px;position:relative;left:750px;background-color:green;width:100px;height:20px;border-radius:5px" href="home.html">Home</a>
        <?php if (count($carList) > 0) { ?>
            <?php foreach ($carList as $car) { ?>
                <div class="card">
                    <img src="<?php echo $car['image']; ?>" alt="Car Image">
                    <h4><?php echo $car['car_name']; ?></h4>
                    <p>Model: <?php echo $car['model']; ?></p>
                    <p>Price: <?php echo $car['price']; ?></p>
                    <div class="book-now">
                        <a href="book.php?id=<?php echo $car['id']; ?>">Book Now</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No cars available.</p>
        <?php } ?>
    </div>
</body>
</html>
