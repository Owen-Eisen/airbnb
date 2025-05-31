<?php
// Include database configuration
include('config/config.php');

/**
 * Fetch all unique neighborhoods from the listings
 * @return array Array of neighborhood names
 */
function getNeighborhoods() {
    $conn = connectDB();
    $neighborhoods = [];
    $columnName = null;

    // Get all columns from the listings table
    $result = $conn->query("SHOW COLUMNS FROM listings");
    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    // Check for neighborhood column variations
    if (in_array('neighborhood', $columns)) {
        $columnName = 'neighborhood';
    } elseif (in_array('neighbourhood', $columns)) {
        $columnName = 'neighbourhood';
    } elseif (in_array('neighbourhood_cleansed', $columns)) {
        $columnName = 'neighbourhood_cleansed';
    } elseif (in_array('neighborhood_cleansed', $columns)) {
        $columnName = 'neighborhood_cleansed';
    }

    // If we found a valid column, query it
    if ($columnName) {
        $query = "SELECT DISTINCT $columnName FROM listings ORDER BY $columnName ASC";
        $result = $conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row[$columnName])) {
                    $neighborhoods[] = $row[$columnName];
                }
            }
        } else {
            error_log("Error fetching neighborhoods: " . $conn->error);
        }
    } else {
        // If no neighborhood column found, return dummy data
        $neighborhoods = ['Downtown', 'Uptown', 'Midtown', 'Suburbs', 'Beach Area'];
        error_log("No neighborhood column found in listings table. Using dummy data.");
    }

    $conn->close();
    return $neighborhoods;
}

/**
 * Fetch all unique room types from the listings
 * @return array Array of room type names
 */
function getRoomTypes() {
    $conn = connectDB();
    $roomTypes = [];
    $columnName = null;

    // Get all columns from the listings table
    $result = $conn->query("SHOW COLUMNS FROM listings");
    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    // Check for room type column variations
    if (in_array('room_type', $columns)) {
        $columnName = 'room_type';
    } elseif (in_array('property_type', $columns)) {
        $columnName = 'property_type';
    } elseif (in_array('room_type_cleansed', $columns)) {
        $columnName = 'room_type_cleansed';
    }

    // If we found a valid column, query it
    if ($columnName) {
        $query = "SELECT DISTINCT $columnName FROM listings ORDER BY $columnName ASC";
        $result = $conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row[$columnName])) {
                    $roomTypes[] = $row[$columnName];
                }
            }
        } else {
            error_log("Error fetching room types: " . $conn->error);
        }
    } else {
        // If no room type column found, return dummy data
        $roomTypes = ['Entire home/apt', 'Private room', 'Shared room', 'Hotel room'];
        error_log("No room type column found in listings table. Using dummy data.");
    }

    $conn->close();
    return $roomTypes;
}

/**
 * Fetch listings based on search criteria
 * @param string $neighborhood Neighborhood filter
 * @param string $room_type Room type filter
 * @param int $guests Number of guests filter
 * @return array Array of listing data
 */
function getListings($neighborhood, $room_type, $guests) {
    $conn = connectDB();
    $listings = [];

    // Get all columns from the listings table
    $result = $conn->query("SHOW COLUMNS FROM listings");
    if (!$result) {
        error_log("Error getting columns: " . $conn->error);
        return $listings;
    }

    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    // Determine column names
    $neighborhoodColumn = null;
    if (in_array('neighborhood', $columns)) {
        $neighborhoodColumn = 'neighborhood';
    } elseif (in_array('neighbourhood', $columns)) {
        $neighborhoodColumn = 'neighbourhood';
    } elseif (in_array('neighbourhood_cleansed', $columns)) {
        $neighborhoodColumn = 'neighbourhood_cleansed';
    } elseif (in_array('neighborhood_cleansed', $columns)) {
        $neighborhoodColumn = 'neighborhood_cleansed';
    }

    $roomTypeColumn = null;
    if (in_array('room_type', $columns)) {
        $roomTypeColumn = 'room_type';
    } elseif (in_array('property_type', $columns)) {
        $roomTypeColumn = 'property_type';
    } elseif (in_array('room_type_cleansed', $columns)) {
        $roomTypeColumn = 'room_type_cleansed';
    }

    $accommodatesColumn = null;
    if (in_array('accommodates', $columns)) {
        $accommodatesColumn = 'accommodates';
    } elseif (in_array('guests', $columns)) {
        $accommodatesColumn = 'guests';
    } elseif (in_array('person_capacity', $columns)) {
        $accommodatesColumn = 'person_capacity';
    }

    // Build the query
    $query = "SELECT * FROM listings WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($neighborhood) && $neighborhoodColumn) {
        $query .= " AND $neighborhoodColumn = ?";
        $params[] = $neighborhood;
        $types .= "s";
    }

    if (!empty($room_type) && $roomTypeColumn) {
        $query .= " AND $roomTypeColumn = ?";
        $params[] = $room_type;
        $types .= "s";
    }

    if (!empty($guests) && $accommodatesColumn) {
        $query .= " AND $accommodatesColumn >= ?";
        $params[] = $guests;
        $types .= "i";
    }

    // Limit to 20 results
    $query .= " LIMIT 20";

    try {
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            error_log("Error preparing statement: " . $conn->error);
            return $listings;
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Create a standardized listing object
            $listing = [];

            // Basic info
            $listing['id'] = $row['id'] ?? 0;
            $listing['name'] = $row['name'] ?? ($row['listing_name'] ?? 'Unnamed Listing');

            // Location info
            if ($neighborhoodColumn && isset($row[$neighborhoodColumn])) {
                $listing['neighborhood'] = $row[$neighborhoodColumn];
            }

            // Room type info
            if ($roomTypeColumn && isset($row[$roomTypeColumn])) {
                $listing['room_type'] = $row[$roomTypeColumn];
            }

            // Accommodates info
            if ($accommodatesColumn && isset($row[$accommodatesColumn])) {
                $listing['accommodates'] = $row[$accommodatesColumn];
            }

            // Price info
            if (isset($row['price'])) {
                // Remove currency symbols and commas
                $price = preg_replace('/[^0-9.]/', '', $row['price']);
                $listing['price'] = floatval($price);
            } else {
                $listing['price'] = 0;
            }

            // Min/Max nights
            $listing['minNights'] = $row['minimum_nights'] ?? ($row['min_nights'] ?? 1);
            $listing['maxNights'] = $row['maximum_nights'] ?? ($row['max_nights'] ?? 30);

            // Reviews
            $listing['numReviews'] = $row['number_of_reviews'] ?? 0;

            // Rating
            if (isset($row['review_scores_rating'])) {
                // Convert from 0-100 to 0-5 if needed
                $rating = floatval($row['review_scores_rating']);
                $listing['rating'] = ($rating > 5) ? $rating / 20 : $rating;
            } else {
                $listing['rating'] = 0;
            }

            // Image URL - use a placeholder image based on the listing ID and name
            // This ensures we have a unique, colorful image for each listing
            $listing['image_url'] = 'https://picsum.photos/seed/' . $listing['id'] . '/600/400';

            // Backup options if we want to try the actual URLs
            if (isset($row['picture_url']) && !empty($row['picture_url']) &&
            filter_var($row['picture_url'], FILTER_VALIDATE_URL)) {
                $listing['original_image_url'] = $row['picture_url'];
            } elseif (isset($row['thumbnail_url']) && !empty($row['thumbnail_url']) &&
            filter_var($row['thumbnail_url'], FILTER_VALIDATE_URL)) {
                $listing['original_image_url'] = $row['thumbnail_url'];
            } elseif (isset($row['medium_url']) && !empty($row['medium_url']) &&
            filter_var($row['medium_url'], FILTER_VALIDATE_URL)) {
                $listing['original_image_url'] = $row['medium_url'];
            } elseif (isset($row['xl_picture_url']) && !empty($row['xl_picture_url']) &&
            filter_var($row['xl_picture_url'], FILTER_VALIDATE_URL)) {
                $listing['original_image_url'] = $row['xl_picture_url'];
            }

            $listings[] = $listing;
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log("Error in getListings: " . $e->getMessage());
    }

    $conn->close();
    return $listings;
}

/**
 * Fetch detailed information about a specific listing
 * @param int $listingId Listing ID
 * @return array Listing details including amenities
 */
function getListingDetails($listingId) {
    $conn = connectDB();
    $listing = [];

    try {
        // Get all columns from the listings table
        $result = $conn->query("SHOW COLUMNS FROM listings");
        if (!$result) {
            error_log("Error getting columns: " . $conn->error);
            return $listing;
        }

        $columns = [];
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }

        // Check if the amenities tables exist
        $hasAmenitiesTable = false;
        $result = $conn->query("SHOW TABLES LIKE 'amenities'");
        if ($result && $result->num_rows > 0) {
            $hasAmenitiesTable = true;
        }

        // Check if the hosts table exists
        $hasHostsTable = false;
        $result = $conn->query("SHOW TABLES LIKE 'hosts'");
        if ($result && $result->num_rows > 0) {
            $hasHostsTable = true;
        }

        // Build the query based on available tables
        if ($hasAmenitiesTable && $hasHostsTable) {
            $query = "SELECT l.*, h.name as host_name, GROUP_CONCAT(a.amenity SEPARATOR ', ') as amenities_list
                      FROM listings l
                      LEFT JOIN hosts h ON l.host_id = h.id
                      LEFT JOIN listing_amenities la ON l.id = la.listing_id
                      LEFT JOIN amenities a ON la.amenity_id = a.id
                      WHERE l.id = ?
                      GROUP BY l.id";
        } elseif ($hasHostsTable) {
            $query = "SELECT l.*, h.name as host_name
                      FROM listings l
                      LEFT JOIN hosts h ON l.host_id = h.id
                      WHERE l.id = ?";
        } else {
            $query = "SELECT * FROM listings WHERE id = ?";
        }

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            error_log("Error preparing statement: " . $conn->error);
            return $listing;
        }

        $stmt->bind_param('i', $listingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // If no result, return empty array
        if (!$row) {
            return $listing;
        }

        // Basic info
        $listing['id'] = $row['id'] ?? 0;
        $listing['name'] = $row['name'] ?? ($row['listing_name'] ?? 'Unnamed Listing');

        // Determine neighborhood column
        if (in_array('neighborhood', $columns) && isset($row['neighborhood'])) {
            $listing['neighborhood'] = $row['neighborhood'];
        } elseif (in_array('neighbourhood', $columns) && isset($row['neighbourhood'])) {
            $listing['neighborhood'] = $row['neighbourhood'];
        } elseif (in_array('neighbourhood_cleansed', $columns) && isset($row['neighbourhood_cleansed'])) {
            $listing['neighborhood'] = $row['neighbourhood_cleansed'];
        } elseif (in_array('neighborhood_cleansed', $columns) && isset($row['neighborhood_cleansed'])) {
            $listing['neighborhood'] = $row['neighborhood_cleansed'];
        } else {
            $listing['neighborhood'] = 'Unknown Area';
        }

        // Determine room_type column
        if (in_array('room_type', $columns) && isset($row['room_type'])) {
            $listing['room_type'] = $row['room_type'];
        } elseif (in_array('property_type', $columns) && isset($row['property_type'])) {
            $listing['room_type'] = $row['property_type'];
        } elseif (in_array('room_type_cleansed', $columns) && isset($row['room_type_cleansed'])) {
            $listing['room_type'] = $row['room_type_cleansed'];
        } else {
            $listing['room_type'] = 'Unknown Type';
        }

        // Determine accommodates
        if (in_array('accommodates', $columns) && isset($row['accommodates'])) {
            $listing['accommodates'] = $row['accommodates'];
        } elseif (in_array('guests', $columns) && isset($row['guests'])) {
            $listing['accommodates'] = $row['guests'];
        } elseif (in_array('person_capacity', $columns) && isset($row['person_capacity'])) {
            $listing['accommodates'] = $row['person_capacity'];
        } else {
            $listing['accommodates'] = 1;
        }

        // Price info
        if (isset($row['price'])) {
            // Remove currency symbols and commas
            $price = preg_replace('/[^0-9.]/', '', $row['price']);
            $listing['price'] = floatval($price);
        } else {
            $listing['price'] = 0;
        }

        // Determine host name
        if (isset($row['host_name'])) {
            $listing['host'] = $row['host_name'];
        } elseif (isset($row['host'])) {
            $listing['host'] = $row['host'];
        } else {
            $listing['host'] = 'Unknown Host';
        }

        // Image URL - use a placeholder image based on the listing ID
        // This ensures we have a unique, colorful image for each listing
        $listing['image_url'] = 'https://picsum.photos/seed/' . $listing['id'] . '/600/400';

        // Backup options if we want to try the actual URLs
        if (isset($row['picture_url']) && !empty($row['picture_url']) &&
        filter_var($row['picture_url'], FILTER_VALIDATE_URL)) {
            $listing['original_image_url'] = $row['picture_url'];
        } elseif (isset($row['thumbnail_url']) && !empty($row['thumbnail_url']) &&
        filter_var($row['thumbnail_url'], FILTER_VALIDATE_URL)) {
            $listing['original_image_url'] = $row['thumbnail_url'];
        } elseif (isset($row['medium_url']) && !empty($row['medium_url']) &&
        filter_var($row['medium_url'], FILTER_VALIDATE_URL)) {
            $listing['original_image_url'] = $row['medium_url'];
        } elseif (isset($row['xl_picture_url']) && !empty($row['xl_picture_url']) &&
        filter_var($row['xl_picture_url'], FILTER_VALIDATE_URL)) {
            $listing['original_image_url'] = $row['xl_picture_url'];
        } elseif (isset($row['image_url']) && !empty($row['image_url']) &&
        filter_var($row['image_url'], FILTER_VALIDATE_URL)) {
            $listing['original_image_url'] = $row['image_url'];
        }

        // Ensure we have rating
        if (isset($row['review_scores_rating'])) {
            // Convert from 0-100 to 0-5 if needed
            $rating = floatval($row['review_scores_rating']);
            $listing['rating'] = ($rating > 5) ? $rating / 20 : $rating;
        } elseif (isset($row['rating'])) {
            $listing['rating'] = floatval($row['rating']);
        } else {
            $listing['rating'] = 0;
        }

        // Process amenities
        $listing['amenities'] = [];

        // Check for amenities from the join
        if (isset($row['amenities_list']) && !empty($row['amenities_list'])) {
            $listing['amenities'] = explode(', ', $row['amenities_list']);
        }
        // Check for amenities in the listings table
        elseif (isset($row['amenities']) && !empty($row['amenities'])) {
            $amenitiesStr = $row['amenities'];

            // Try to parse as JSON if it looks like JSON
            if (substr($amenitiesStr, 0, 1) === '[' && substr($amenitiesStr, -1) === ']') {
                $amenitiesArray = json_decode($amenitiesStr, true);
                if (is_array($amenitiesArray)) {
                    $listing['amenities'] = $amenitiesArray;
                } else {
                    // If JSON parsing fails, try simple splitting
                    $listing['amenities'] = explode(',', trim($amenitiesStr, '[]"'));
                }
            } else {
                // Simple string splitting
                $listing['amenities'] = explode(',', $amenitiesStr);
            }
        }

        // Clean up amenities array
        $listing['amenities'] = array_map('trim', $listing['amenities']);
        $listing['amenities'] = array_filter($listing['amenities'], function($item) {
            return !empty($item);
        });

        // If still no amenities, provide some defaults
        if (empty($listing['amenities'])) {
            $listing['amenities'] = ['Wifi', 'Kitchen', 'Heating'];
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log("Error in getListingDetails: " . $e->getMessage());
    }

    $conn->close();
    return $listing;
}
?>
