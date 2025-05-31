<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include functions file
include('../functions.php');

// Get listing ID from the request
$listingId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Log the request
error_log("AJAX request received for listing ID: $listingId");

// Fetch the listing details using the function from functions.php
$listing = getListingDetails($listingId);

// If listing is empty, provide a sample listing
if (empty($listing)) {
    $listing = [
        'id' => $listingId,
        'name' => 'Sample Listing',
        'neighborhood' => 'Sample Neighborhood',
        'room_type' => 'Entire home/apt',
        'accommodates' => 4,
        'price' => 99.99,
        'rating' => 4.5,
        'host' => 'Sample Host',
        'image_url' => 'https://via.placeholder.com/600x400?text=Sample+Image',
        'amenities' => ['Wifi', 'Kitchen', 'Heating']
    ];
    error_log("No listing found for ID: $listingId, using sample data");
}

// Log the result
error_log("Listing data retrieved: " . json_encode($listing));

// Set headers to prevent caching
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Type: application/json');

// Return listing data as JSON
echo json_encode($listing);
?>