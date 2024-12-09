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
                <li class="breadcrumb-item">
                    <a href="{{ route('articles.index') }}">Articles</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View Article</li>
            </ol>
        </nav>

        <!-- Article Card -->
        <div class="card shadow-lg border-light rounded">
            <div class="card-body">
                <!-- Article Title -->
                <h1 class="display-4 text-primary">{{ $article->title }}</h1>

                <!-- Article Metadata -->
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <h5 class="text-muted">Category: <span class="text-dark">{{ $article->category->name }}</span></h5>
                        <h5 class="text-muted">Status: <span class="text-dark">{{ ucfirst($article->status) }}</span></h5>
                    </div>
                    <div>
                        <h6 class="text-muted">Published on: <span class="text-dark">{{ $article->created_at->format('d M, Y') }}</span></h6>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="mt-3">
                    <p class="lead">{!! nl2br(e($article->content)) !!}</p>
                </div>

                <!-- Images -->
                @if($article->images->count())
                    <h5 class="mt-5 mb-3">Images</h5>
                    <div class="row">
                        @foreach($article->images as $image)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="image-container">
                                    <img src="{{ asset($image->file_path) }}" class="img-fluid rounded shadow-sm" alt="Article Image" style="height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Edit and Delete Buttons -->
                <div class="mt-4 d-flex justify-content-end">
                    <!-- Edit Button -->
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i> Edit Article
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline-block;" id="delete-form-{{ $article->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete Article" onclick="confirmDelete({{ $article->id }})">
                                        <i class="fas fa-trash-alt"></i> Delete Article
                                    </button>
                                </form>
                </div>
               
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Articles
            </a>
        </div>
    </main>
</div>
<script src="{{ asset('js/articles.js') }}"></script>

@endsection
