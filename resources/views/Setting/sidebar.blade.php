@extends('layouts.app')

@section('content')
<div class="content">
    <main class="p-4">
        
        <!-- <div class="container"> -->
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Sidebars</li>
                </ol>
            </nav>

            <!-- <h2 class="mb-4 font-weight-bold text-primary">Sidebars Management</h2> -->

            <!-- Create Sidebar Button -->
            <button id="createSidebarBtn" class="btn btn-primary mb-3 "><i class="fas fa-plus-circle"></i> Create Sidebar</button>

            @if (session('success'))
                <div class="alert alert-success fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif
        <!-- </div> -->
        
        <!-- Sidebar Table -->
        <div class="card shadow-lg border-light rounded">

            <div class="card-body">
                <div class="table-responsive">
                    <table id="sidebarTable" class="table table-hover table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Icon</th>
                                <th>Order</th>
                                <th>Parent Sidebar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sidebarTableBody">
                            @foreach($sidebars as $sidebar)
                                <tr data-id="{{ $sidebar->id }}">
                                    <td>{{ $sidebar->title }}</td>
                                    <td>{{ $sidebar->url }}</td>
                                    <td>{{ $sidebar->icon }}</td>
                                    <td>{{ $sidebar->order }}</td>
                                    <td>{{ $sidebar->parent_id ? $sidebar->parent_id : 'None' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm editSidebarBtn" data-id="{{ $sidebar->id }}" data-toggle="tooltip" title="Edit Sidebar">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteSidebarBtn" data-id="{{ $sidebar->id }}" data-toggle="tooltip" title="Delete Sidebar">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal for Create/Edit Sidebar -->
<div class="modal fade" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="sidebarModalLabel">Create Sidebar</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sidebarForm">
                    @csrf
                    <input type="hidden" id="sidebarId">
                    
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control form-control-line" id="title" name="title" required placeholder="Enter Sidebar Title">
                    </div>
                    
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control form-control-line" id="url" name="url" placeholder="Enter URL">
                    </div>
                    
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" class="form-control form-control-line" id="icon" name="icon" placeholder="Enter Icon (optional)">
                    </div>
                    
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="number" class="form-control form-control-line" id="order" name="order" placeholder="Order">
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" id="is_active" name="is_active" class="form-check-input">
                        <label for="is_active" class="form-check-label">Is Active</label>
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" id="admin_access_only" name="admin_access_only" class="form-check-input">
                        <label for="admin_access_only" class="form-check-label">Admin Access Only</label>
                    </div>
                    
                    <div class="form-group">
                        <label for="parent_id">Parent Sidebar</label>
                        <select class="form-control form-control-line" id="parent_id" name="parent_id">
                            <option value="">None</option>
                            @foreach($sidebars as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success" id="saveSidebarBtn">
                        <i class="fas fa-save"></i> Save Sidebar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/form-line.css') }}">

<script src="{{ asset('js/sidebar.js') }}"></script>
@endsection
