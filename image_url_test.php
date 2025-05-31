<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
include('config/config.php');

// Connect to the database
$conn = connectDB();

// Get a few sample listings
$result = $conn->query("SELECT id, name FROM listings LIMIT 5");
$listings = [];
while ($row = $result->fetch_assoc()) {
    $listings[] = $row;
}

echo "<h1>Image URL Test</h1>";

// For each listing, check all possible image URL columns
foreach ($listings as $listing) {
    echo "<h2>Listing: " . htmlspecialchars($listing['name']) . " (ID: " . $listing['id'] . ")</h2>";
    
    $query = "SELECT * FROM listings WHERE id = " . $listing['id'];
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    
    // Check all possible image URL columns
    $imageColumns = ['picture_url', 'thumbnail_url', 'medium_url', 'xl_picture_url', 'image_url'];
    echo "<table border='1'>";
    echo "<tr><th>Column</th><th>Value</th><th>Preview</th></tr>";
    
    foreach ($imageColumns as $column) {
        echo "<tr>";
        echo "<td>" . $column . "</td>";
        if (isset($row[$column])) {
            echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
            echo "<td><img src='" . htmlspecialchars($row[$column]) . "' style='max-width: 200px; max-height: 200px;' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/200x200?text=Error'; this.style.border='2px solid red';\"></td>";
        } else {
            echo "<td>Not found</td><td>N/A</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
    // Try to create a working image URL
    echo "<h3>Testing Different Image URL Formats</h3>";
    
    // Test 1: Direct URL
    if (isset($row['picture_url'])) {
        echo "<p>Direct URL: <img src='" . htmlspecialchars($row['picture_url']) . "' style='max-width: 200px; max-height: 200px;' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/200x200?text=Direct+URL+Error'; this.style.border='2px solid red';\"></p>";
    }
    
    // Test 2: Placeholder
    echo "<p>Placeholder: <img src='https://via.placeholder.com/200x200?text=Test' style='max-width: 200px; max-height: 200px;'></p>";
    
    // Test 3: Data URL (if available)
    if (isset($row['picture_url']) && strpos($row['picture_url'], 'data:image') === 0) {
        echo "<p>Data URL: <img src='" . htmlspecialchars($row['picture_url']) . "' style='max-width: 200px; max-height: 200px;' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/200x200?text=Data+URL+Error'; this.style.border='2px solid red';\"></p>";
    }
    
    echo "<hr>";
}

$conn->close();
?>
