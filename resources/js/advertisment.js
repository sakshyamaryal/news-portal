
 function renderAdvertisementCard(advertisement) {
    return `
    <div class="col-md-4 col-sm-6 col-lg-3 mb-4" id="advertisement-${advertisement.id}">
        <div class="card shadow-sm border-0">
            ${advertisement.image_url ? 
                `<img class="card-img-top rounded-top" 
                       src="${advertisement.image_url}" 
                       alt="${advertisement.title}" 
                       style="height: 180px; object-fit: cover;">` :
                `<div class="card-img-top bg-light d-flex justify-content-center align-items-center" 
                       style="height: 180px; color: #ccc; font-size: 1.5rem;">
                       <i class="fas fa-image"></i>
                   </div>`
            }
            <div class="card-body text-center">
                <h6 class="card-title mb-2 font-weight-bold">${advertisement.title}</h6>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-primary edit-btn mx-1" data-id="${advertisement.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-btn mx-1" data-id="${advertisement.id}">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>`;
}

// Add Advertisement via AJAX
$('#addAdvertisementForm').submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
        url: '{{ route(`advertisements.store`) }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#advertisementsGrid').append(renderAdvertisementCard(response));
            $('#addAdvertisementModal').modal('hide');
            $('#addAdvertisementForm')[0].reset();
            toastr.success('Advertisement added successfully!');
        },
        error: function(xhr) {
            toastr.error('Error: ' + xhr.responseJSON.error);
        }
    });
});

// Edit Advertisement via AJAX
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');  // Get the advertisement ID
        $.get(`/advertisements/${id}/edit`, function(response) {
            // Check if the response contains the advertisement data
            if (response) {
                // Populate the form fields with advertisement data
                $('#editAdvertisementForm').attr('action', `advertisements/${id}`);
                $('#editTitle').val(response.title);  // Set title
                $('#editLink').val(response.link_url);  // Set link URL
                $('#editStatus').val(response.is_active);  // Set status
                
                // If there's an image URL, show it or set it to a default value if not present
                $('#editImage').val('');  // Clear the file input by default
                if (response.image_url) {
                    $('#editImage').after(`<img src="${response.image_url}" alt="${response.title}" class="img-fluid mt-2" style="max-height: 150px;">`);
                } else {
                    $('#editImage').after('<p class="text-muted">No image uploaded.</p>');
                }
                
                // Show the modal
                $('#editAdvertisementModal').modal('show');
            }
        });
    });


// Update Advertisement via AJAX
$('#editAdvertisementForm').submit(function(e) {
    e.preventDefault();
    const id = $(this).attr('action').split('/').pop();
    const formData = new FormData(this);
    console.log(formData);
    $.ajax({
        url: `advertisements/${id}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  
        },
        success: function(response) {
            const card = renderAdvertisementCard(response);
            $(`#advertisement-${id}`).replaceWith(card);
            $('#editAdvertisementModal').modal('hide');
            toastr.success('Advertisement updated successfully!');
        },
        error: function(xhr) {
            toastr.error('Error: ' + xhr.responseJSON.error);
        }
    });
});

// Delete Advertisement via AJAX
$(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: 'This advertisement will be deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `advertisements/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $(`#advertisement-${id}`).remove();
                    Swal.fire('Deleted!', 'The advertisement has been deleted.', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'There was an error deleting the advertisement.', 'error');
                }
            });
        }
    });
});

$(document).ready(function() {
    // Search functionality
    $('#advertisementSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();  // Get the search term in lowercase
        
        // Loop through all the advertisement cards
        $('.advertisement-card').each(function() {
            const cardTitle = $(this).data('title');  // Get the title of each advertisement card
            
            // If the title includes the search term, show the card; otherwise, hide it
            if (cardTitle.includes(searchTerm)) {
                $(this).show();  // Show matching card
            } else {
                $(this).hide();  // Hide non-matching card
            }
        });
    });
});
