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
$result = $conn->query("SHOW TABLES FROM fakeAirbnb");
echo "Tables in fakeAirbnb database:\n";
while ($row = $result->fetch_row()) {
    echo "- " . $row[0] . "\n";
}

// Check listings table structure
$result = $conn->query("DESCRIBE listings");
echo "\nStructure of listings table:\n";
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
}

// Check amenities table structure
$result = $conn->query("DESCRIBE amenities");
echo "\nStructure of amenities table:\n";
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
}

// Check listing_amenities table structure
$result = $conn->query("DESCRIBE listing_amenities");
echo "\nStructure of listing_amenities table:\n";
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
}

$conn->close();
?>
