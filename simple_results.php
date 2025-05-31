<?php
// Get search parameters
$neighborhood = isset($_GET['neighborhood']) ? $_GET['neighborhood'] : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
$guests = isset($_GET['guests']) ? intval($_GET['guests']) : 0;

// Create some sample listings
$allListings = [
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
        'image_url' => 'https://picsum.photos/seed/1/600/400',
        'host' => 'John Doe',
        'amenities' => ['Wifi', 'Kitchen', 'Air conditioning', 'Washer', 'Dryer']
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
        'image_url' => 'https://picsum.photos/seed/2/600/400',
        'host' => 'Jane Smith',
        'amenities' => ['Wifi', 'Kitchen', 'Gym', 'Pool']
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
        'image_url' => 'https://picsum.photos/seed/3/600/400',
        'host' => 'Mike Johnson',
        'amenities' => ['Wifi', 'Shared kitchen', 'Laundry']
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
        'image_url' => 'https://picsum.photos/seed/4/600/400',
        'host' => 'Sarah Williams',
        'amenities' => ['Wifi', 'Kitchen', 'Pool', 'Hot tub', 'Gym', 'Beach access']
    ],
    [
        'id' => 5,
        'name' => 'Charming Studio in Historic District',
        'neighborhood' => 'Downtown',
        'room_type' => 'Entire home/apt',
        'accommodates' => 2,
        'price' => 95.00,
        'minNights' => 2,
        'maxNights' => 21,
        'numReviews' => 53,
        'rating' => 4.7,
        'image_url' => 'https://picsum.photos/seed/5/600/400',
        'host' => 'David Brown',
        'amenities' => ['Wifi', 'Kitchen', 'Historic building']
    ],
    [
        'id' => 6,
        'name' => 'Spacious Family Home',
        'neighborhood' => 'Suburbs',
        'room_type' => 'Entire home/apt',
        'accommodates' => 8,
        'price' => 180.00,
        'minNights' => 3,
        'maxNights' => 30,
        'numReviews' => 29,
        'rating' => 4.6,
        'image_url' => 'https://picsum.photos/seed/6/600/400',
        'host' => 'Emily Davis',
        'amenities' => ['Wifi', 'Kitchen', 'Backyard', 'BBQ grill', 'Parking']
    ],
    [
        'id' => 7,
        'name' => 'Cozy Room in Shared Apartment',
        'neighborhood' => 'Midtown',
        'room_type' => 'Private room',
        'accommodates' => 1,
        'price' => 55.00,
        'minNights' => 1,
        'maxNights' => 14,
        'numReviews' => 41,
        'rating' => 4.3,
        'image_url' => 'https://picsum.photos/seed/7/600/400',
        'host' => 'Alex Wilson',
        'amenities' => ['Wifi', 'Shared kitchen', 'Laundry']
    ],
    [
        'id' => 8,
        'name' => 'Beachfront Bungalow',
        'neighborhood' => 'Beach Area',
        'room_type' => 'Entire home/apt',
        'accommodates' => 4,
        'price' => 220.00,
        'minNights' => 4,
        'maxNights' => 60,
        'numReviews' => 38,
        'rating' => 4.9,
        'image_url' => 'https://picsum.photos/seed/8/600/400',
        'host' => 'Jessica Taylor',
        'amenities' => ['Wifi', 'Kitchen', 'Beach access', 'Ocean view']
    ]
];

// Filter listings based on search criteria
$listings = [];
foreach ($allListings as $listing) {
    $match = true;
    
    if (!empty($neighborhood) && $listing['neighborhood'] != $neighborhood) {
        $match = false;
    }
    
    if (!empty($room_type) && $listing['room_type'] != $room_type) {
        $match = false;
    }
    
    if (!empty($guests) && $listing['accommodates'] < $guests) {
        $match = false;
    }
    
    if ($match) {
        $listings[] = $listing;
    }
}
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
        <a class="navbar-brand" href="simple_index.php">Fake Airbnb</a>
      </div>
    </nav>
    
    <main>
      <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
          <h1>Search Results</h1>
          <a href="simple_index.php" class="btn btn-outline-danger">New Search</a>
        </div>
        
        <?php if (empty($listings)): ?>
          <div class="no-results">
            <h3>No listings found matching your criteria</h3>
            <p>Try adjusting your search filters or <a href="simple_index.php">start a new search</a>.</p>
          </div>
        <?php else: ?>
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
                    <p class="card-text"><strong>Rating:</strong> 
                      <span class="text-warning">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                          <?php if($i <= round($listing['rating'])): ?>
                            ★
                          <?php else: ?>
                            ☆
                          <?php endif; ?>
                        <?php endfor; ?>
                      </span>
                      <?= number_format(floatval($listing['rating']), 1) ?> / 5
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
        <?php endif; ?>
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
                  <p id="modal-rating" class="text-warning"></p>
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
      // Store listing data in a JavaScript object for easy access
      const listingData = {
        <?php foreach ($allListings as $listing): ?>
        <?= $listing['id'] ?>: {
          name: <?= json_encode($listing['name']) ?>,
          neighborhood: <?= json_encode($listing['neighborhood']) ?>,
          room_type: <?= json_encode($listing['room_type']) ?>,
          accommodates: <?= $listing['accommodates'] ?>,
          price: <?= $listing['price'] ?>,
          rating: <?= $listing['rating'] ?>,
          numReviews: <?= $listing['numReviews'] ?>,
          host: <?= json_encode($listing['host']) ?>,
          image_url: <?= json_encode($listing['image_url']) ?>,
          amenities: <?= json_encode($listing['amenities']) ?>
        },
        <?php endforeach; ?>
      };
      
      $(document).on('click', '.viewListing', function() {
        var listingId = $(this).data('id');
        console.log('View button clicked for listing ID:', listingId);
        
        // Get the listing data from our JavaScript object
        var listing = listingData[listingId];
        
        if (listing) {
          // Populate the modal with the listing details
          $('#modal-title').text(listing.name);
          $('#modal-image').attr('src', listing.image_url);
          $('#modal-neighborhood').text('Neighborhood: ' + listing.neighborhood);
          $('#modal-price').text('Price: $' + listing.price.toFixed(2) + ' / night');
          $('#modal-accommodates').text('Accommodates: ' + listing.accommodates + ' guests');
          
          // Create star rating
          var ratingText = '';
          for (var i = 1; i <= 5; i++) {
            if (i <= Math.round(listing.rating)) {
              ratingText += '★'; // Filled star
            } else {
              ratingText += '☆'; // Empty star
            }
          }
          $('#modal-rating').html(ratingText + ' ' + listing.rating.toFixed(1) + '/5 (' + listing.numReviews + ' reviews)');
          
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
