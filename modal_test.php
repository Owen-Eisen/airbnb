<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Modal Test Page</h1>
        <p>This page tests the modal functionality directly.</p>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal">
            Open Test Modal
        </button>
        
        <hr>
        
        <h2>Test AJAX Request</h2>
        <div class="mb-3">
            <label for="listingId" class="form-label">Listing ID:</label>
            <input type="number" class="form-control" id="listingId" value="1" min="1">
        </div>
        <button id="testAjaxBtn" class="btn btn-success">Test AJAX Request</button>
        <div id="ajaxResult" class="mt-3 p-3 border"></div>
    </div>
    
    <!-- Test Modal -->
    <div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modal-title">Test Listing</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modal-image" src="https://via.placeholder.com/600x400?text=Test+Image" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Image+Error';">
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <p id="modal-neighborhood" class="fw-bold">Neighborhood: Test Neighborhood</p>
                                <p id="modal-price" class="text-danger fw-bold">Price: $99.99</p>
                                <p id="modal-accommodates">Accommodates: 4</p>
                                <p id="modal-rating">Rating: 4.5/5</p>
                            </div>
                            <div class="col-md-6">
                                <p id="modal-host" class="fw-bold">Hosted by: Test Host</p>
                                <p id="modal-amenities">Amenities: Wifi, Kitchen, Heating</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Test AJAX request
            $('#testAjaxBtn').on('click', function() {
                var listingId = $('#listingId').val();
                $('#ajaxResult').html('<p>Loading...</p>');
                
                // Try direct AJAX request
                $.get('src/ajax.php', { id: listingId })
                .done(function(data) {
                    console.log('AJAX response:', data);
                    var resultHtml = '<h4>AJAX Response:</h4>';
                    resultHtml += '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                    $('#ajaxResult').html(resultHtml);
                    
                    // Update modal with the data
                    $('#modal-title').text(data.name || 'Listing Details');
                    $('#modal-image').attr('src', data.image_url || 'https://via.placeholder.com/600x400?text=No+Image');
                    $('#modal-neighborhood').text('Neighborhood: ' + (data.neighborhood || 'Not specified'));
                    $('#modal-price').text('Price: $' + (data.price ? Number(data.price).toFixed(2) : '0.00'));
                    $('#modal-accommodates').text('Accommodates: ' + (data.accommodates || 'Not specified'));
                    $('#modal-rating').text('Rating: ' + (data.rating ? Number(data.rating).toFixed(1) : '0.0') + '/5');
                    $('#modal-host').text('Hosted by: ' + (data.host || 'Unknown Host'));
                    
                    if (Array.isArray(data.amenities) && data.amenities.length > 0) {
                        $('#modal-amenities').text('Amenities: ' + data.amenities.join(', '));
                    } else {
                        $('#modal-amenities').text('Amenities: None listed');
                    }
                    
                    // Open the modal
                    var modal = new bootstrap.Modal(document.getElementById('testModal'));
                    modal.show();
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX request failed:', textStatus, errorThrown);
                    $('#ajaxResult').html('<div class="alert alert-danger">Error: ' + textStatus + '</div>');
                    
                    // Try the test file
                    $.get('ajax_test.php')
                    .done(function(testData) {
                        $('#ajaxResult').append('<div class="alert alert-warning">Test AJAX successful. Using test data instead.</div>');
                        $('#ajaxResult').append('<pre>' + JSON.stringify(testData, null, 2) + '</pre>');
                        
                        // Update modal with test data
                        $('#modal-title').text(testData.test_data.name);
                        $('#modal-image').attr('src', testData.test_data.image_url);
                        $('#modal-neighborhood').text('Neighborhood: ' + testData.test_data.neighborhood);
                        $('#modal-price').text('Price: $' + testData.test_data.price.toFixed(2));
                        $('#modal-accommodates').text('Accommodates: ' + testData.test_data.accommodates);
                        $('#modal-rating').text('Rating: ' + testData.test_data.rating.toFixed(1) + '/5');
                        $('#modal-host').text('Hosted by: ' + testData.test_data.host);
                        $('#modal-amenities').text('Amenities: ' + testData.test_data.amenities.join(', '));
                        
                        // Open the modal
                        var modal = new bootstrap.Modal(document.getElementById('testModal'));
                        modal.show();
                    });
                });
            });
        });
    </script>
</body>
</html>
