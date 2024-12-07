 // Render Category Card Function (JavaScript Only)
 function renderCategoryCard(category) {
    return `
    <div class="col-md-4 col-sm-6 col-lg-3 mb-4" id="category-${category.id}">
        <div class="card shadow-sm border-0">
            ${category.image ? 
                `<img class="card-img-top rounded-top" 
                       src="${category.image}" 
                       alt="${category.name}" 
                       style="height: 180px; object-fit: cover;">` :
                `<div class="card-img-top bg-light d-flex justify-content-center align-items-center" 
                       style="height: 180px; color: #ccc; font-size: 1.5rem;">
                       <i class="fas fa-image"></i>
                   </div>`
            }
            <div class="card-body text-center">
                <h6 class="card-title mb-2 font-weight-bold">${category.name}</h6>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-primary edit-btn mx-1" data-id="${category.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-btn mx-1" data-id="${category.id}">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>`;
}



// Edit Category
$(document).on('click', '.edit-btn', function() {
    const id = $(this).data('id');
    $.get(`/admin_categories/edit/${id}`, function(response) {
        $('#editName').val(response.name);
        $('#editCategoryForm').attr('action', `/admin_categories/${id}`);
        $('#editCategoryModal').modal('show');
    });
});

// Add Category
$('#addCategoryForm').submit(function(e) {
e.preventDefault();
const formData = new FormData(this);
$.ajax({
    url: categoryStoreUrl,
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        $('#categoriesGrid').append(renderCategoryCard(response));
        $('#addCategoryModal').modal('hide');
        $('#addCategoryForm')[0].reset();
        toastr.success('Category added successfully!');
    },
    error: function(xhr) {
        const error = xhr.responseJSON.error || 'An error occurred while adding the category.';
        toastr.error(error);
    }
});
});

$(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin_categories/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  
                },
                success: function(response) {
                    if (response.success) {
                        $(`#category-${id}`).remove();
                        Swal.fire(
                            'Deleted!',
                            'The category has been deleted.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the category.',
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON.error || 'An error occurred while deleting the category.';
                    Swal.fire(
                        'Error!',
                        error,
                        'error'
                    );
                }
            });
        }
    });
});

// Update Category
$('#editCategoryForm').submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const id = $(this).attr('action').split('/').pop();
    $.ajax({
        url: `/admin_categories/${id}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $(`#category-${response.id}`).replaceWith(renderCategoryCard(response));
            $('#editCategoryModal').modal('hide');
            toastr.success('Category updated successfully!');
        },
        error: function(xhr) {
            const error = xhr.responseJSON.error || 'An error occurred while updating the category.';
            toastr.error(error);
        }
    });
});
