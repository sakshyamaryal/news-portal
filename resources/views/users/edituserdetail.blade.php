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
<link rel="stylesheet" href="{{ asset('css/edit-user-detail.css') }}">
<script> 
var upload_url =  "{{ route('profile.upload-image') }}";
var csrf_token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/edit-user-detail.js') }}"></script>
@endsection