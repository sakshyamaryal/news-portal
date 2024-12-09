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
                <li class="breadcrumb-item active" aria-current="page">Articles</li>
            </ol>
        </nav>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif


        <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus-circle"></i> Create New Article</a>

        <div class="card shadow-lg border-light rounded">
            <div class="card-body">

                <form method="GET" action="{{ route('articles.index') }}" class="mb-3">
                    <div class="row">
                        <!-- Category Filter -->
                        <div class="col-md-3 mb-3">
                            <label for="filter-category" class="form-label">Category</label>
                            <select name="category" id="filter-category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Author Filter -->
                        <div class="col-md-3 mb-3">
                            <label for="filter-author" class="form-label">Author</label>
                            <select name="author" id="filter-author" class="form-control">
                                <option value="">All Authors</option>
                                @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range Filters -->
                        <div class="col-md-3 mb-3">
                            <label for="filter-start-date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="filter-start-date" class="form-control" value="{{ request('start_date') }}" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="filter-end-date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="filter-end-date" class="form-control" value="{{ request('end_date') }}" />
                        </div>

                        <!-- Timeframe Filter -->
                        <div class="col-md-3 mb-3">
                            <label for="timeframe" class="form-label">Timeframe</label>
                            <select name="timeframe" class="form-control" id="timeframe">
                                <option value="">All Time</option>
                                <option value="last_month" {{ request('timeframe') == 'last_month' ? 'selected' : '' }}>Past Month</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="filter-status" class="form-label">Status</label>
                            <select name="status" id="filter-status" class="form-control">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                        </div>

                        <!-- Reset Filter Button -->
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <a href="{{ route('articles.index') }}" class="btn btn-danger w-100">
                                <i class="fas fa-times-circle"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                </form>


                <!-- DataTable -->
                <table id="articles-table" class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ $article->author->name }}</td>
                            <td> <span class="badge badge-{{ $article->status === 'published' ? 'success' : 'danger' }}">{{ ucfirst($article->status) }}</span></td>
                            <td>
                                <!-- View Button with Icon -->
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm" title="View Article">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Edit Button with Icon -->
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm" title="Edit Article">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Button with Icon -->
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline-block;" id="delete-form-{{ $article->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete Article" onclick="confirmDelete({{ $article->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No articles found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>
    </main>
</div>

<script src="{{ asset('js/articles.js') }}"></script>

@endsection