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
            </ol>
        </nav>

        <div class="card shadow-lg border-light rounded">
            <div class="card-body">

                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control form-control-line" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select form-control-line" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <textarea name="content" id="content" rows="5" class=" form-control form-control-line" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Upload Images</label>
                        <input type="file" name="images[]" id="images" class="form-control form-control-line" multiple>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm">Create Article</button>
                </form>
            </div>
        </div>
    </main>
</div>
<link rel="stylesheet" href="{{ asset('css/form-line.css') }}">
<!-- Include CKEditor 5 -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script> -->
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     ClassicEditor
    //         .create(document.querySelector('#content'))
    //         .then(editor => {
    //             console.log(editor);
    //         })
    //         .catch(error => {
    //             console.error(error);
    //         });
    // });
</script>
@endsection
