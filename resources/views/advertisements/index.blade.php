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
                <li class="breadcrumb-item active" aria-current="page">Advertisements</li>
            </ol>
        </nav>

        <div class="card shadow-lg border-light rounded">

            
            <div class="m-2 float-right d-flex justify-content-between align-items-center">
                @can('manage advertisements')
                <button class="btn btn-primary" data-toggle="modal" data-target="#addAdvertisementModal">
                    <i class="fas fa-plus"></i> Add Advertisement
                </button>
                @endcan
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" id="advertisementSearch" class="form-control" placeholder="Search advertisements..." autocomplete="off">
                    </div>
                </div>

            </div>
            <div class="card-body">
                
                <div class="row" id="advertisementsGrid">
                    @foreach ($advertisements as $advertisement)
                    <div class="col-md-4 col-sm-6 col-lg-3 mb-4 advertisement-card" data-title="{{ strtolower($advertisement->title) }}"  id="advertisement-{{ $advertisement->id }}">
                        <div class="card shadow-sm border-0" >
                            @if ($advertisement->image_url)
                            <img class="card-img-top rounded-top" src="{{ $advertisement->image_url }}" alt="{{ $advertisement->title }}" style="height: 180px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-light d-flex justify-content-center align-items-center" style="height: 180px; color: #ccc; font-size: 1.5rem;">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2 font-weight-bold">{{ $advertisement->title }}</h6>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary edit-btn mx-1" data-id="{{ $advertisement->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger delete-btn mx-1" data-id="{{ $advertisement->id }}">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
<!-- Add Advertisement Modal -->
<div class="modal fade" id="addAdvertisementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addAdvertisementForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Advertisement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addTitle">Title</label>
                        <input type="text" id="addTitle" name="title" class="form-control form-control-line" required placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="addImage">Image</label>
                        <input type="file" id="addImage" name="image" class="form-control-file" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="addLink">Link URL</label>
                        <input type="text" id="addLink" name="link_url" class="form-control form-control-line" required placeholder="Enter URL">
                    </div>
                    <div class="form-group">
                        <label for="addStatus">Active</label>
                        <select id="addStatus" name="is_active" class="form-control form-control-line">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Advertisement Modal -->
<div class="modal fade" id="editAdvertisementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editAdvertisementForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Advertisement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" id="editTitle" name="title" class="form-control form-control-line" required placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="editImage">Image</label>
                        <input type="file" id="editImage" name="image" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="editLink">Link URL</label>
                        <input type="text" id="editLink" name="link_url" class="form-control form-control-line" required placeholder="Enter URL">
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Active</label>
                        <select id="editStatus" name="is_active" class="form-control form-control-line">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/form-line.css') }}">
<style>
    #advertisementSearch {
        border-radius: 25px;  /* Rounded corners */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Subtle shadow for depth */
    }

    .input-group-text {
        background-color: #f8f9fa;  /* Light background color */
        border: none;  /* Remove border around the icon */
    }

    .input-group-prepend .input-group-text {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }

    .input-group-text i {
        color: #007bff;  /* Icon color */
    }

    .form-group {
        margin-bottom: 20px;  /* Add space below the search bar */
    }

</style>

    <script>
        const advertisementStoreUrl = '{{ route("advertisements.store") }}';
    </script>
    <script src="{{ asset('js/advertisement.js') }}"></script>

@endsection