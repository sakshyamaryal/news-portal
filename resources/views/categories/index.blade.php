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
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>

        <div class="card">
            <div class="m-2 float-right d-flex justify-content-between align-items-center">
                @if(auth()->user()->can('manage category'))
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="row" id="categoriesGrid">
                    @foreach ($categories as $category)
                        <div class="col-md-4 col-sm-6 col-lg-3 mb-4" id="category-{{ $category->id }}">
                            <div class="card shadow-sm border-0">
                                @if ($category->image)
                                    <img class="card-img-top rounded-top" 
                                         src="{{ $category->image }}" 
                                         alt="{{ $category->name }}" 
                                         style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex justify-content-center align-items-center" 
                                         style="height: 180px; color: #ccc; font-size: 1.5rem;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="card-body text-center">
                                    <h6 class="card-title mb-2 font-weight-bold">{{ $category->name }}</h6>
                                    <div class="d-flex justify-content-center">
                                        @if(auth()->user()->can('manage category')) <!-- Check if the user can manage categories -->
                                            <button class="btn btn-sm btn-outline-primary edit-btn mx-1" data-id="{{ $category->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-btn mx-1" data-id="{{ $category->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="fas fa-eye"></i> View Only
                                            </button>
                                        @endif
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
<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addCategoryForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addName">Name</label>
                        <input type="text" id="addName" name="name" class="form-control form-control-line" required>
                    </div>
                    <div class="form-group">
                        <label for="addImage">Image</label>
                        <input type="file" id="addImage" name="image" class="form-control form-control-line">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCategoryForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" id="editName" name="name" class="form-control form-control-line" required>
                    </div>
                    <div class="form-group">
                        <label for="editImage">Image</label>
                        <input type="file" id="editImage" name="image" class="form-control form-control-line">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/form-line.css') }}">

<script>
   const categoryStoreUrl = "{{ route('categories.store') }}";

</script>
<script src="{{ asset('js/category.js') }}"></script>
@endsection
