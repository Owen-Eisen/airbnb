<?php
// Database connection settings
define("SERVER", "mysqlServer");
define("PORT", "3306");
define("USERNAME", "fakeAirbnbUser");
define("PASSWORD", "apples11Million");
define("DATABASE", "fakeAirbnb");

// Connect to the database
function connectDB() {
    $conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE, PORT);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

$conn = connectDB();

// Show tables
echo "<h2>Tables in database:</h2>";
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    echo "- " . $row[0] . "<br>";
}

// Check listings table structure
echo "<h2>Structure of listings table:</h2>";
$result = $conn->query("DESCRIBE listings");
if ($result) {
    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Error: " . $conn->error;
}

// Show a sample row from listings
echo "<h2>Sample row from listings:</h2>";
$result = $conn->query("SELECT * FROM listings LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<pre>";
    print_r($row);
    echo "</pre>";
} else {
    echo "No data in listings table or error: " . $conn->error;
}

$conn->close();
?>
