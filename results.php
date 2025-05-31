<?php
include('functions.php');

// Get search parameters from the form
$neighborhood = isset($_GET['neighborhood']) ? $_GET['neighborhood'] : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
$guests = isset($_GET['guests']) ? $_GET['guests'] : '';

// Get the listings based on the search criteria
$listings = getListings($neighborhood, $room_type, $guests);
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
          <h1>Search Results</h1>
          <a href="index.php" class="btn btn-outline-danger">New Search</a>
        </div>

        <?php if (empty($listings)): ?>
          <div class="no-results">
            <h3>No listings found matching your criteria</h3>
            <p>Try adjusting your search filters or <a href="index.php">start a new search</a>.</p>
          </div>
        <?php else: ?>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php foreach ($listings as $listing): ?>
              <div class="col">
                <div class="card shadow-sm h-100">
                  <img src="<?= htmlspecialchars($listing['image_url'] ?? 'https://via.placeholder.com/300x200?text=No+Image') ?>" alt="<?= htmlspecialchars($listing['name'] ?? 'Listing Image') ?>" class="card-img-top" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Image+Error';">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($listing['name'] ?? 'Unnamed Listing') ?></h5>
                    <?php if (isset($listing['neighborhood'])): ?>
                      <p class="card-text"><strong>Neighborhood:</strong> <?= htmlspecialchars($listing['neighborhood']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($listing['room_type'])): ?>
                      <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($listing['room_type']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($listing['accommodates'])): ?>
                      <p class="card-text"><strong>Accommodates:</strong> <?= intval($listing['accommodates']) ?> guests</p>
                    <?php endif; ?>
                    <?php if (isset($listing['price'])): ?>
                      <p class="card-text"><strong>Price:</strong> $<?= number_format(floatval($listing['price']), 2) ?> / night</p>
                    <?php endif; ?>
                    <p class="card-text"><strong>Rating:</strong>
                      <?php if (isset($listing['rating']) && $listing['rating'] > 0): ?>
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
                      <?php else: ?>
                        No ratings yet
                      <?php endif; ?>
                      <?php if (isset($listing['numReviews']) && $listing['numReviews'] > 0): ?>
                        (<?= intval($listing['numReviews']) ?> reviews)
                      <?php endif; ?>
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
            <img id="modal-image" src="image_url_placeholder.jpg" class="img-fluid" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Image+Error';">
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
    <script src="js/script.js"></script>
  </body>
</html>
