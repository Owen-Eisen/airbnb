$(document).on('click', '.viewListing', function() {
    var listingId = $(this).data('id');

    // Show loading state
    $('#modal-title').text('Loading...');
    $('#modal-image').attr('src', 'https://via.placeholder.com/600x400?text=Loading...');
    $('#modal-neighborhood, #modal-price, #modal-accommodates, #modal-rating, #modal-host, #modal-amenities').text('');

    // Log the click and listing ID
    console.log('View button clicked for listing ID:', listingId);

    // Use jQuery's ajax method with more options
    $.ajax({
        url: 'direct_test.php',  // First try our diagnostic page
        method: 'GET',
        dataType: 'html',  // Expect HTML response
        success: function(response) {
            console.log('Direct test successful');

            // Now try the actual AJAX request
            $.ajax({
                url: 'src/ajax.php',
                method: 'GET',
                data: { id: listingId },
                dataType: 'json',  // Expect JSON response
                success: function(data) {
                    console.log('AJAX response received:', data);

                    // Populate the modal with the listing details
                    $('#modal-title').text(data.name || 'Listing Details');

                    // Handle image URL
                    var imageUrl = data.image_url || 'https://via.placeholder.com/600x400?text=No+Image';
                    $('#modal-image').attr('src', imageUrl);

                    // Set other details
                    $('#modal-neighborhood').text('Neighborhood: ' + (data.neighborhood || 'Not specified'));
                    $('#modal-price').text('Price: $' + (data.price ? Number(data.price).toFixed(2) : '0.00'));
                    $('#modal-accommodates').text('Accommodates: ' + (data.accommodates || 'Not specified'));
                    // Create star rating
                    var ratingValue = data.rating ? Number(data.rating) : 0;
                    var ratingText = '';
                    for (var i = 1; i <= 5; i++) {
                        if (i <= Math.round(ratingValue)) {
                            ratingText += '★'; // Filled star
                        } else {
                            ratingText += '☆'; // Empty star
                        }
                    }
                    $('#modal-rating').html(ratingText + ' ' + (ratingValue ? ratingValue.toFixed(1) : '0.0') + '/5');
                    $('#modal-host').text('Hosted by: ' + (data.host || 'Unknown Host'));

                    // Amenities should be an array, join them into a string
                    if (Array.isArray(data.amenities) && data.amenities.length > 0) {
                        $('#modal-amenities').text('Amenities: ' + data.amenities.join(', '));
                    } else {
                        $('#modal-amenities').text('Amenities: None listed');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX request failed:', textStatus, errorThrown);

                    // Use hardcoded data as a last resort
                    $('#modal-title').text('Sample Listing (Error Loading Data)');
                    $('#modal-image').attr('src', 'https://via.placeholder.com/600x400?text=Sample+Image');
                    $('#modal-neighborhood').text('Neighborhood: Sample Neighborhood');
                    $('#modal-price').text('Price: $99.99');
                    $('#modal-accommodates').text('Accommodates: 4');
                    $('#modal-rating').html('★★★★☆ 4.5/5');
                    $('#modal-host').text('Hosted by: Sample Host');
                    $('#modal-amenities').text('Amenities: Wifi, Kitchen, Heating');
                }
            });
        },
        error: function() {
            console.error('Direct test failed');

            // Use hardcoded data as a last resort
            $('#modal-title').text('Sample Listing (Error)');
            $('#modal-image').attr('src', 'https://via.placeholder.com/600x400?text=Sample+Image');
            $('#modal-neighborhood').text('Neighborhood: Sample Neighborhood');
            $('#modal-price').text('Price: $99.99');
            $('#modal-accommodates').text('Accommodates: 4');
            $('#modal-rating').html('★★★★☆ 4.5/5');
            $('#modal-host').text('Hosted by: Sample Host');
            $('#modal-amenities').text('Amenities: Wifi, Kitchen, Heating');
        }
    });
});
