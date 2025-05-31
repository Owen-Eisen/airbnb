<?php
// Create some sample listings
$listings = [
    [
        'id' => 1,
        'name' => 'Cozy Apartment in Downtown',
        'neighborhood' => 'Downtown',
        'room_type' => 'Entire home/apt',
        'accommodates' => 4,
        'price' => 120.00,
        'minNights' => 2,
        'maxNights' => 14,
        'numReviews' => 45,
        'rating' => 4.8,
        'image_url' => 'https://via.placeholder.com/600x400?text=Cozy+Apartment',
        'host' => 'John Doe'
    ],
    [
        'id' => 2,
        'name' => 'Modern Loft with City View',
        'neighborhood' => 'Midtown',
        'room_type' => 'Entire home/apt',
        'accommodates' => 2,
        'price' => 150.00,
        'minNights' => 3,
        'maxNights' => 30,
        'numReviews' => 32,
        'rating' => 4.5,
        'image_url' => 'https://via.placeholder.com/600x400?text=Modern+Loft',
        'host' => 'Jane Smith'
    ],
    [
        'id' => 3,
        'name' => 'Private Room in Shared House',
        'neighborhood' => 'Uptown',
        'room_type' => 'Private room',
        'accommodates' => 1,
        'price' => 65.00,
        'minNights' => 1,
        'maxNights' => 7,
        'numReviews' => 18,
        'rating' => 4.2,
        'image_url' => 'https://via.placeholder.com/600x400?text=Private+Room',
        'host' => 'Mike Johnson'
    ],
    [
        'id' => 4,
        'name' => 'Luxury Condo with Pool',
        'neighborhood' => 'Beach Area',
        'room_type' => 'Entire home/apt',
        'accommodates' => 6,
        'price' => 250.00,
        'minNights' => 5,
        'maxNights' => 90,
        'numReviews' => 67,
        'rating' => 4.9,
        'image_url' => 'https://via.placeholder.com/600x400?text=Luxury+Condo',
        'host' => 'Sarah Williams'
    ]
];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fake Airbnb Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
      <div class="container">
        <a class="navbar-brand" href="index.php">Fake Airbnb</a>
      </div>
    </nav>
    
    <main>
      <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
          <h1>Hardcoded Results</h1>
          <a href="index.php" class="btn btn-outline-danger">New Search</a>
        </div>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
          <?php foreach ($listings as $listing): ?>
            <div class="col">
              <div class="card shadow-sm h-100">
                <img src="<?= htmlspecialchars($listing['image_url']) ?>" alt="<?= htmlspecialchars($listing['name']) ?>" class="card-img-top" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Image+Error';">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($listing['name']) ?></h5>
                  <p class="card-text"><strong>Neighborhood:</strong> <?= htmlspecialchars($listing['neighborhood']) ?></p>
                  <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($listing['room_type']) ?></p>
                  <p class="card-text"><strong>Accommodates:</strong> <?= intval($listing['accommodates']) ?> guests</p>
                  <p class="card-text"><strong>Price:</strong> $<?= number_format(floatval($listing['price']), 2) ?> / night</p>
                  <p class="card-text"><strong>Rating:</strong> <?= number_format(floatval($listing['rating']), 1) ?> / 5 
                    (<?= intval($listing['numReviews']) ?> reviews)
                  </p>
                  <div class="mt-auto">
                    <button type="button" class="btn btn-danger viewListing" data-bs-toggle="modal" data-bs-target="#listingModal" data-id="<?= intval($listing['id']) ?>">View Details</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="listingModal" tabindex="-1" aria-labelledby="listingModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modal-title">Listing Name</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img id="modal-image" src="https://via.placeholder.com/600x400?text=Loading..." class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Image+Error';">
          </div>
          <div class="modal-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <p id="modal-neighborhood" class="fw-bold"></p>
                  <p id="modal-price" class="text-danger fw-bold"></p>
                  <p id="modal-accommodates"></p>
                  <p id="modal-rating"></p>
                </div>
                <div class="col-md-6">
                  <p id="modal-host" class="fw-bold"></p>
                  <p id="modal-amenities"></p>
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

    <footer class="bg-light py-3 mt-5">
      <div class="container text-center">
        <p class="text-muted mb-0">Fake Airbnb - Created for CS293 Spring 2025</p>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Hardcoded listing data for the modal
      const listingData = {
        1: {
          name: 'Cozy Apartment in Downtown',
          neighborhood: 'Downtown',
          price: 120.00,
          accommodates: 4,
          rating: 4.8,
          host: 'John Doe',
          image_url: 'https://via.placeholder.com/600x400?text=Cozy+Apartment',
          amenities: ['Wifi', 'Kitchen', 'Air conditioning', 'Washer', 'Dryer']
        },
        2: {
          name: 'Modern Loft with City View',
          neighborhood: 'Midtown',
          price: 150.00,
          accommodates: 2,
          rating: 4.5,
          host: 'Jane Smith',
          image_url: 'https://via.placeholder.com/600x400?text=Modern+Loft',
          amenities: ['Wifi', 'Kitchen', 'Gym', 'Pool']
        },
        3: {
          name: 'Private Room in Shared House',
          neighborhood: 'Uptown',
          price: 65.00,
          accommodates: 1,
          rating: 4.2,
          host: 'Mike Johnson',
          image_url: 'https://via.placeholder.com/600x400?text=Private+Room',
          amenities: ['Wifi', 'Shared kitchen', 'Laundry']
        },
        4: {
          name: 'Luxury Condo with Pool',
          neighborhood: 'Beach Area',
          price: 250.00,
          accommodates: 6,
          rating: 4.9,
          host: 'Sarah Williams',
          image_url: 'https://via.placeholder.com/600x400?text=Luxury+Condo',
          amenities: ['Wifi', 'Kitchen', 'Pool', 'Hot tub', 'Gym', 'Beach access']
        }
      };
      
      $(document).on('click', '.viewListing', function() {
        var listingId = $(this).data('id');
        console.log('View button clicked for listing ID:', listingId);
        
        // Get the listing data from our hardcoded object
        var listing = listingData[listingId];
        
        if (listing) {
          // Populate the modal with the listing details
          $('#modal-title').text(listing.name);
          $('#modal-image').attr('src', listing.image_url);
          $('#modal-neighborhood').text('Neighborhood: ' + listing.neighborhood);
          $('#modal-price').text('Price: $' + listing.price.toFixed(2) + ' / night');
          $('#modal-accommodates').text('Accommodates: ' + listing.accommodates + ' guests');
          $('#modal-rating').text('Rating: ' + listing.rating.toFixed(1) + '/5');
          $('#modal-host').text('Hosted by: ' + listing.host);
          $('#modal-amenities').text('Amenities: ' + listing.amenities.join(', '));
        } else {
          // Fallback for missing data
          $('#modal-title').text('Listing Details Not Available');
          $('#modal-image').attr('src', 'https://via.placeholder.com/600x400?text=No+Details+Available');
          $('#modal-neighborhood, #modal-price, #modal-accommodates, #modal-rating, #modal-host, #modal-amenities').text('Information not available');
        }
      });
    </script>
  </body>
</html>
