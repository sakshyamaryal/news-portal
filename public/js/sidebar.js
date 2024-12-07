$(document).ready(function() {
    $('#sidebarTable').DataTable();

    // Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();

    // Open the Create Sidebar modal
    $('#createSidebarBtn').click(function() {
        $('#sidebarModalLabel').text('Create Sidebar');
        $('#sidebarForm')[0].reset();
        $('#sidebarId').val('');
        $('#sidebarModal').modal('show');
    });

    // Open the Edit Sidebar modal
    $(document).on('click', '.editSidebarBtn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/sidebars/' + id,
            method: 'GET',
            success: function(data) {
                $('#sidebarModalLabel').text('Edit Sidebar');
                $('#sidebarId').val(data.sidebar.id);
                $('#title').val(data.sidebar.title);
                $('#url').val(data.sidebar.url);
                $('#icon').val(data.sidebar.icon);
                $('#order').val(data.sidebar.order);
                $('#is_active').prop('checked', data.sidebar.is_active);
                $('#admin_access_only').prop('checked', data.sidebar.admin_access_only);
                $('#parent_id').val(data.sidebar.parent_id);
                $('#sidebarModal').modal('show');
            },
            error: function(xhr, status, error) {
                toastr.error('Error fetching sidebar data.');
            }
        });
    });

    // Save or update the sidebar
    $('#sidebarForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var sidebarId = $('#sidebarId').val();
        var url = sidebarId ? '/sidebars/' + sidebarId : '/sidebars';
        var method = sidebarId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#sidebarModal').modal('hide');
                    toastr.success('Sidebar saved successfully!');
                    // Optionally, reload the page or update the table data dynamically.
                } else {
                    toastr.error('An error occurred while saving the sidebar.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while saving the sidebar.');
            }
        });
    });

    // Delete Sidebar
    $(document).on('click', '.deleteSidebarBtn', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this sidebar?')) {
            $.ajax({
                url: '/sidebars/' + id,
                method: 'DELETE',
                data: {
                _token: $('meta[name="csrf-token"]').attr('content')  
            },
                success: function(response) {
                    if(response.success) {
                        $('tr[data-id="'+ id +'"]').remove();
                        toastr.success('Sidebar deleted successfully!');
                    } else {
                        toastr.error('An error occurred while deleting the sidebar.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while deleting the sidebar.');
                }
            });
        }
    });
});
