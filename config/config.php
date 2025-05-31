<?php
// Database connection constants
define("SERVER", "mysqlServer");
define("PORT", "3306");
define("USERNAME", "fakeAirbnbUser");
define("PASSWORD", "apples11Million");
define("DATABASE", "fakeAirbnb");

/**
 * Connect to the database
 * @return mysqli Database connection object
 */
function connectDB() {
    $conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE, PORT);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
