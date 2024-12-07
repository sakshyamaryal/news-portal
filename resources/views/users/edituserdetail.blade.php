@extends('layouts.app')

@section('content')
<div class="content">
    <main class="p-4">
        <div class="container py-8">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="row g-0">
                            <!-- Left Column - Profile Image -->
                            <div class="col-md-4 border-end">
                                <div class="p-4 p-md-5">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-4">Profile Photo</h6>

                                    <div class="text-center">
                                        <div class="profile-image-container mb-4">
                                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" alt="Profile Picture" class="profile-image" id="profile-image-preview">
                                        </div>

                                        <div class="upload-controls">
                                            <label for="profile_image" class="btn btn-outline-secondary btn-sm d-block mb-2">
                                                Change Photo
                                            </label>
                                            <input id="profile_image" type="file" class="form-control d-none" name="profile_image" accept="image/*">
                                            <span class="text-muted small">Maximum file size: 5MB</span>
                                        </div>

                                        <div id="upload-status" class="mt-3 small"></div>
                                        @error('profile_image')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Edit Form -->
                            <div class="col-md-8">
                                <div class="p-4 p-md-5">
                                    <h6 class="text-uppercase text-muted small fw-semibold mb-4">Account Information</h6>

                                    <form method="POST" action="{{ url('/profile') }}" enctype="multipart/form-data" id="profile-form">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <label for="name" class="form-label small text-muted">Full Name</label>
                                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="email" class="form-label small text-muted">Email Address</label>
                                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mt-5 mb-4">
                                            <h6 class="text-uppercase text-muted small fw-semibold mb-4">Change Password</h6>

                                            <div class="mb-4">
                                                <label for="password" class="form-label small text-muted">New Password</label>
                                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                                @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="password-confirm" class="form-label small text-muted">Confirm New Password</label>
                                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-5">
                                            <a href="{{ route('profile.show') }}" class="btn btn-link text-muted text-decoration-none">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary px-4 py-2">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<style>
    .container {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        background-color: #fff;
    }

    .profile-image-container {
        width: 140px;
        height: 140px;
        margin: 0 auto;
        position: relative;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px rgb(0 0 0 / 0.1);
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgb(59 130 246 / 0.1);
    }

    .btn {
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
        padding: 0.5rem 1.5rem;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border-width: 1.5px;
        padding: 0.5rem 1rem;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    #upload-status {
        min-height: 20px;
    }

    #upload-status.text-info {
        color: #3b82f6 !important;
    }

    #upload-status.text-success {
        color: #10b981 !important;
    }

    #upload-status.text-danger {
        color: #ef4444 !important;
    }

    @media (max-width: 768px) {
        .border-end {
            border: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
    }
</style>


<script>
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
                formData.append('_token', '{{ csrf_token() }}');

                $('#upload-status').html('<span class="spinner-border spinner-border-sm me-2"></span>Uploading...').removeClass('text-success text-danger').addClass('text-info');

                $.ajax({
                    url: '{{ route("profile.upload-image") }}',
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
</script>
@endsection