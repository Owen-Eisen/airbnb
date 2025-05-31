<?php
// This is a simple test file to check if AJAX is working correctly
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'AJAX is working!',
    'timestamp' => date('Y-m-d H:i:s'),
    'test_data' => [
        'name' => 'Test Listing',
        'neighborhood' => 'Test Neighborhood',
        'price' => 99.99,
        'accommodates' => 4,
        'rating' => 4.5,
        'host' => 'Test Host',
        'image_url' => 'https://via.placeholder.com/600x400?text=Test+Image',
        'amenities' => ['Wifi', 'Kitchen', 'Heating']
    ]
]);
?>
