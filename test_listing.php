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

echo "<h1>Testing Listing Details</h1>";
echo "<p>Testing with listing ID: $listingId</p>";

// Fetch the listing details
$listing = getListingDetails($listingId);

// Display the result
echo "<h2>Listing Details</h2>";
echo "<pre>";
print_r($listing);
echo "</pre>";

// Test the modal display
echo "<h2>Modal Display Test</h2>";
?>

<div id="testModal">
    <h3 id="modal-title"><?= htmlspecialchars($listing['name'] ?? 'Unnamed Listing') ?></h3>
    <div id="modal-image">
        <img src="<?= htmlspecialchars($listing['image_url'] ?? 'https://via.placeholder.com/300x200?text=No+Image') ?>" 
             style="max-width: 300px;" 
             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Image+Error';">
    </div>
    <div>
        <p id="modal-neighborhood">Neighborhood: <?= htmlspecialchars($listing['neighborhood'] ?? 'Not specified') ?></p>
        <p id="modal-price">Price: $<?= number_format(floatval($listing['price'] ?? 0), 2) ?></p>
        <p id="modal-accommodates">Accommodates: <?= intval($listing['accommodates'] ?? 0) ?></p>
        <p id="modal-rating">Rating: <?= number_format(floatval($listing['rating'] ?? 0), 1) ?>/5</p>
        <p id="modal-host">Hosted by: <?= htmlspecialchars($listing['host'] ?? 'Unknown Host') ?></p>
        <p id="modal-amenities">Amenities: <?= is_array($listing['amenities'] ?? null) ? implode(', ', $listing['amenities']) : 'None listed' ?></p>
    </div>
</div>

<h2>AJAX Test</h2>
<p>Click the button below to test the AJAX request:</p>
<button id="testAjax" data-id="<?= $listingId ?>">Test AJAX Request</button>
<div id="ajaxResult" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#testAjax').on('click', function() {
        var listingId = $(this).data('id');
        $('#ajaxResult').html('<p>Loading...</p>');
        
        $.get('src/ajax.php', { id: listingId })
        .done(function(data) {
            console.log('AJAX response:', data);
            var resultHtml = '<h3>AJAX Response:</h3>';
            resultHtml += '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            $('#ajaxResult').html(resultHtml);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX request failed:', textStatus, errorThrown);
            $('#ajaxResult').html('<p>Error: ' + textStatus + '</p><p>' + errorThrown + '</p>');
        });
    });
});
</script>
