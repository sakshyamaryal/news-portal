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
                <li class="breadcrumb-item active" aria-current="page">Edit Article</li>
            </ol>
        </nav>

        <div class="card shadow-lg border-light rounded">
            @if($article->images->count())
            <h5 class="card-header">Existing Images</h5>
            <div class="row m-3">
                @foreach($article->images as $image)
                <div class="col-md-3 position-relative">
                    <img src="{{ asset($image->file_path) }}" class="img-thumbnail" alt="Article Image" style="width: 100%; height: 200px; object-fit: cover;">
                    <form action="{{ route('images.destroy', $image) }}" method="POST" style="position:absolute; top:5px; right:5px; z-index: 10;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">X</button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif

            <div class="card-body">

                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control form-control-line" value="{{ old('title', $article->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select form-control-line" required>
                            <option value="" disabled>Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select form-control-line" required>
                            <option value="draft" {{ old('status', $article->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $article->status ?? 'draft') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $article->status ?? 'draft') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
              


                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="content" rows="5" class="form-control form-control-line" required>{{ old('content',  $article->content) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Upload Images (Optional)</label>
                        <input type="file" name="images[]" id="images" class="form-control form-control-line" multiple>
                    </div>



                    <button type="submit" class="btn btn-success btn-sm">Update Article</button>
                </form>
            </div>


        </div>
    </main>
</div>
<link rel="stylesheet" href="{{ asset('css/form-line.css') }}">

@endsection