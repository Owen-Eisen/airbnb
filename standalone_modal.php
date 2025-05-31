<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standalone Modal Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            padding: 20px;
        }
        .test-card {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Standalone Modal Test</h1>
        <p>This page tests the modal functionality without relying on AJAX.</p>
        
        <div class="test-card">
            <h3>Test 1: Basic Modal</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                Open Basic Modal
            </button>
        </div>
        
        <div class="test-card">
            <h3>Test 2: Listing Modal</h3>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#listingModal">
                Open Listing Modal
            </button>
        </div>
        
        <div class="test-card">
            <h3>Test 3: JavaScript Modal</h3>
            <button type="button" class="btn btn-danger" id="jsModalBtn">
                Open JavaScript Modal
            </button>
        </div>
    </div>
    
    <!-- Basic Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-labelledby="basicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Basic Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This is a basic modal with static content.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Listing Modal -->
    <div class="modal fade" id="listingModal" tabindex="-1" aria-labelledby="listingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modal-title">Sample Listing</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modal-image" src="https://via.placeholder.com/600x400?text=Sample+Image" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Image+Error';">
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <p id="modal-neighborhood" class="fw-bold">Neighborhood: Sample Neighborhood</p>
                                <p id="modal-price" class="text-danger fw-bold">Price: $99.99</p>
                                <p id="modal-accommodates">Accommodates: 4</p>
                                <p id="modal-rating">Rating: 4.5/5</p>
                            </div>
                            <div class="col-md-6">
                                <p id="modal-host" class="fw-bold">Hosted by: Sample Host</p>
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
    
    <!-- JavaScript Modal (same structure as Listing Modal) -->
    <div class="modal fade" id="jsModal" tabindex="-1" aria-labelledby="jsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="js-modal-title">JavaScript Modal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="js-modal-image" src="https://via.placeholder.com/600x400?text=JS+Modal+Image" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Image+Error';">
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <p id="js-modal-neighborhood" class="fw-bold">Neighborhood: JS Neighborhood</p>
                                <p id="js-modal-price" class="text-danger fw-bold">Price: $199.99</p>
                                <p id="js-modal-accommodates">Accommodates: 6</p>
                                <p id="js-modal-rating">Rating: 4.8/5</p>
                            </div>
                            <div class="col-md-6">
                                <p id="js-modal-host" class="fw-bold">Hosted by: JS Host</p>
                                <p id="js-modal-amenities">Amenities: Wifi, Pool, Kitchen, AC</p>
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
            // JavaScript Modal Button
            $('#jsModalBtn').on('click', function() {
                // Update modal content
                $('#js-modal-title').text('JavaScript Modal - Updated');
                $('#js-modal-image').attr('src', 'https://via.placeholder.com/600x400?text=Updated+JS+Image');
                $('#js-modal-neighborhood').text('Neighborhood: Updated JS Neighborhood');
                $('#js-modal-price').text('Price: $299.99');
                $('#js-modal-accommodates').text('Accommodates: 8');
                $('#js-modal-rating').text('Rating: 5.0/5');
                $('#js-modal-host').text('Hosted by: Updated JS Host');
                $('#js-modal-amenities').text('Amenities: Updated Amenities List');
                
                // Show the modal
                var jsModal = new bootstrap.Modal(document.getElementById('jsModal'));
                jsModal.show();
            });
        });
    </script>
</body>
</html>
