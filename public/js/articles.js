$(document).ready(function() {
    var table = $('#articles-table').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
    });
});

function confirmDelete(articleId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + articleId).submit();
        }
    });
}