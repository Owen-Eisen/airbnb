<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include functions file
include('functions.php');

// Get a sample listing ID
$conn = connectDB();
$result = $conn->query("SELECT id FROM listings LIMIT 1");
$row = $result->fetch_assoc();
$listingId = $row['id'] ?? 1;
$conn->close();

echo "<h1>Direct Test of Listing Details</h1>";
echo "<p>Testing with listing ID: $listingId</p>";

// Fetch the listing details directly
$listing = getListingDetails($listingId);

// Display the raw result
echo "<h2>Raw Listing Data</h2>";
echo "<pre>";
print_r($listing);
echo "</pre>";

// Display the data that would be shown in the modal
echo "<h2>Modal Display Data</h2>";
echo "<table border='1'>";
echo "<tr><th>Field</th><th>Value</th></tr>";
echo "<tr><td>Name</td><td>" . htmlspecialchars($listing['name'] ?? 'Not available') . "</td></tr>";
echo "<tr><td>Image URL</td><td>" . htmlspecialchars($listing['image_url'] ?? 'Not available') . "</td></tr>";
echo "<tr><td>Neighborhood</td><td>" . htmlspecialchars($listing['neighborhood'] ?? 'Not available') . "</td></tr>";
echo "<tr><td>Price</td><td>$" . number_format(floatval($listing['price'] ?? 0), 2) . "</td></tr>";
echo "<tr><td>Accommodates</td><td>" . intval($listing['accommodates'] ?? 0) . "</td></tr>";
echo "<tr><td>Rating</td><td>" . number_format(floatval($listing['rating'] ?? 0), 1) . "/5</td></tr>";
echo "<tr><td>Host</td><td>" . htmlspecialchars($listing['host'] ?? 'Not available') . "</td></tr>";
echo "<tr><td>Amenities</td><td>";
if (is_array($listing['amenities'] ?? null) && !empty($listing['amenities'])) {
    echo htmlspecialchars(implode(', ', $listing['amenities']));
} else {
    echo "None listed";
}
echo "</td></tr>";
echo "</table>";

// Test the image
echo "<h2>Image Test</h2>";
echo "<p>Attempting to display the image:</p>";
echo "<img src=\"" . htmlspecialchars($listing['image_url'] ?? 'https://via.placeholder.com/300x200?text=No+Image') . "\" style=\"max-width: 300px;\" onerror=\"this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Image+Error';\">";

// Test the AJAX endpoint directly
echo "<h2>AJAX Endpoint Test</h2>";
echo "<p>Testing the AJAX endpoint directly:</p>";
echo "<pre>";
$ajaxUrl = "src/ajax.php?id=$listingId";
echo "URL: $ajaxUrl\n\n";
$ch = curl_init($ajaxUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch) . "\n";
} else {
    echo "Response:\n";
    echo $response;
}
curl_close($ch);
echo "</pre>";
?>
