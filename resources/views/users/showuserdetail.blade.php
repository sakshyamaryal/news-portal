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

<link rel="stylesheet" href="{{ asset('css/user-detail.css') }}">
@endsection