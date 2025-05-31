<?php
// Include database configuration
include('config/config.php');

// Connect to the database
$conn = connectDB();

// Get a sample listing
$result = $conn->query("SELECT * FROM listings LIMIT 1");
$listing = $result->fetch_assoc();

echo "<h1>Image URL Debug</h1>";

// Display all columns that might contain image URLs
$imageColumns = ['picture_url', 'thumbnail_url', 'medium_url', 'xl_picture_url', 'image_url'];
echo "<h2>Image URL Columns</h2>";
echo "<table border='1'>";
echo "<tr><th>Column</th><th>Value</th><th>Preview</th></tr>";

foreach ($imageColumns as $column) {
    echo "<tr>";
    echo "<td>$column</td>";
    if (isset($listing[$column])) {
        echo "<td>" . htmlspecialchars($listing[$column]) . "</td>";
        echo "<td><img src='" . htmlspecialchars($listing[$column]) . "' style='max-width: 200px; max-height: 200px;' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/200x200?text=Error'; this.style.border='2px solid red';\"></td>";
    } else {
        echo "<td>Not found</td><td>N/A</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Display all columns that might contain image-related data
echo "<h2>All Columns with 'image', 'picture', 'photo', or 'thumbnail' in the name</h2>";
echo "<table border='1'>";
echo "<tr><th>Column</th><th>Value</th></tr>";

foreach ($listing as $column => $value) {
    if (stripos($column, 'image') !== false || 
        stripos($column, 'picture') !== false || 
        stripos($column, 'photo') !== false || 
        stripos($column, 'thumbnail') !== false) {
        echo "<tr>";
        echo "<td>$column</td>";
        echo "<td>" . htmlspecialchars($value) . "</td>";
        echo "</tr>";
    }
}
echo "</table>";

// Display a sample of all columns
echo "<h2>All Columns</h2>";
echo "<table border='1'>";
echo "<tr><th>Column</th><th>Value</th></tr>";

foreach ($listing as $column => $value) {
    echo "<tr>";
    echo "<td>$column</td>";
    echo "<td>" . (strlen($value) > 100 ? htmlspecialchars(substr($value, 0, 100)) . "..." : htmlspecialchars($value)) . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
