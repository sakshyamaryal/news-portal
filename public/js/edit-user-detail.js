$(document).ready(function() {
    $('#profile_image').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            // File size validation (5MB)
            if (file.size > 5 * 1024 * 1024) {
                $('#upload-status').text('File size exceeds 5MB limit.').removeClass('text-info text-success').addClass('text-danger');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('profile_image', file);
            formData.append('_token', csrf_token);

            $('#upload-status').html('<span class="spinner-border spinner-border-sm me-2"></span>Uploading...').removeClass('text-success text-danger').addClass('text-info');

            $.ajax({
                url: upload_url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#upload-status').text('Photo uploaded successfully!').removeClass('text-info text-danger').addClass('text-success');
                },
                error: function(xhr, status, error) {
                    $('#upload-status').text('Error uploading photo. Please try again.').removeClass('text-info text-success').addClass('text-danger');
                    console.error(error);
                }
            });
        }
    });
});