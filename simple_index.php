<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fake Airbnb - Simple Version</title>
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
        <div class="row mt-4">
          <div class="col-md-8 offset-md-2">
            <div class="form-container">
              <h1 class="text-center mb-4">Find Your Perfect Stay</h1>
              <form method="GET" action="simple_results.php">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="neighborhood" class="form-label">Neighborhood</label>
                    <select name="neighborhood" id="neighborhood" class="form-select">
                      <option value="">Any neighborhood</option>
                      <option value="Downtown">Downtown</option>
                      <option value="Uptown">Uptown</option>
                      <option value="Midtown">Midtown</option>
                      <option value="Beach Area">Beach Area</option>
                      <option value="Suburbs">Suburbs</option>
                    </select>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="room_type" class="form-label">Room Type</label>
                    <select name="room_type" id="room_type" class="form-select">
                      <option value="">Any room type</option>
                      <option value="Entire home/apt">Entire home/apt</option>
                      <option value="Private room">Private room</option>
                      <option value="Shared room">Shared room</option>
                      <option value="Hotel room">Hotel room</option>
                    </select>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="guests" class="form-label">Number of Guests</label>
                    <select name="guests" id="guests" class="form-select">
                      <option value="">Any number</option>
                      <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                      <?php endfor; ?>
                    </select>
                  </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-3">
                  <button type="submit" class="btn btn-danger btn-lg">Search Listings</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="bg-light py-3 mt-5">
      <div class="container text-center">
        <p class="text-muted mb-0">Fake Airbnb - Created for CS293 Spring 2025</p>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
