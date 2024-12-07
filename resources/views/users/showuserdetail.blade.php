@extends('layouts.app')

@section('content')
<div class="content">
    <main class="p-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
<div class="container py-8">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="row g-0">
                    <!-- Left Column - Profile Image -->
                    <div class="col-md-4 border-end">
                        <div class="p-4 p-md-5 text-center">
                            <div class="profile-image-container mb-4">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Picture" class="profile-image">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Picture" class="profile-image">
                                @endif
                            </div>
                            <h4 class="fw-semibold mb-1">{{ $user->name }}</h4>
                            <p class="text-muted small mb-4">{{ $user->getRoleNames()->implode(', ') ?: 'Not specified' }}</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary px-4">
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Right Column - Profile Details -->
                    <div class="col-md-8">
                        <div class="p-4 p-md-5">
                            <h6 class="text-uppercase text-muted small fw-semibold mb-4">Profile Information</h6>
                            
                            <div class="profile-details">
                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <p class="small text-muted mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="mb-0">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <p class="small text-muted mb-0">Email Address</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <p class="small text-muted mb-0">Role</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="mb-0">{{ $user->getRoleNames()->implode(', ') ?: 'Not specified' }}</p>
                                    </div>
                                </div>
                            
                            </div>
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
        width: 160px;
        height: 160px;
        margin: 0 auto;
        position: relative;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 2px 4px rgb(0 0 0 / 0.1);
    }

    .btn-outline-primary {
        border-width: 1.5px;
        font-weight: 500;
        /* padding: 0.5rem 1.5rem; */
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        /* background-color: var(--bs-primary); */
        transform: translateY(-1px);
    }

    .profile-details {
        color: #334155;
    }

    .profile-details .row:not(:last-child) {
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1rem;
    }

    .alert {
        border: none;
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .border-end {
            border: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
    }
</style>
@endsection