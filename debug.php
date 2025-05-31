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

// Function to display table structure
function displayTableStructure($conn, $tableName) {
    echo "<h3>Structure of $tableName table:</h3>";
    $result = $conn->query("DESCRIBE $tableName");
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
}

// Function to display sample data
function displaySampleData($conn, $tableName, $limit = 1) {
    echo "<h3>Sample data from $tableName table:</h3>";
    $result = $conn->query("SELECT * FROM $tableName LIMIT $limit");
    if ($result && $result->num_rows > 0) {
        echo "<pre>";
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>";
    } else {
        echo "No data in $tableName table or error: " . $conn->error;
    }
}

// Main code
$conn = connectDB();

// Show tables
echo "<h2>Tables in database:</h2>";
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
    echo "- " . $row[0] . "<br>";
}

// Display structure and sample data for each table
foreach ($tables as $table) {
    displayTableStructure($conn, $table);
    displaySampleData($conn, $table);
    echo "<hr>";
}

$conn->close();
?>
