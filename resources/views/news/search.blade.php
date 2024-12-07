@extends('userlayouts.app')

@section('title', 'Search Results')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white py-3 text-center" style="background-color: #0056b3;">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <a href="{{ route('category.articles', $category->id) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">
                                {{ $category->articles_count ?? 0 }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Search Results -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="mb-4 fw-bold">
                        <i class="bi bi-search me-3 text-primary"></i>
                        Search Results for: "{{ $query }}"
                    </h2>

                    @if($articles->count() > 0)
                        @foreach($articles as $article)
                            <div class="card border-0 mb-4 hover-lift">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if($article->images->isNotEmpty())
                                            <img src="{{ asset($article->images->first()->file_path) }}" 
                                                 class="img-fluid rounded-start object-cover h-100" 
                                                 alt="{{ $article->title }}"
                                                 style="max-height: 250px;">
                                        @else
                                            <img src="https://via.placeholder.com/400x250" 
                                                 class="img-fluid rounded-start object-cover" 
                                                 alt="{{ $article->title }}"
                                                 style="max-height: 250px;">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold mb-2">
                                                {{ $article->title }}
                                            </h5>
                                            <p class="text-muted small mb-3">
                                                <i class="bi bi-clock me-2"></i>
                                                {{ $article->created_at->diffForHumans() }} 
                                                · {{ $article->author->name }}
                                            </p>
                                            <p class="card-text text-muted mb-3">
                                                {{ Str::limit($article->content, 200) }}
                                            </p>
                                            <a href="{{ route('article.show', $article->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $articles->appends(['query' => $query])->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            No articles found matching your search query.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .object-cover {
        object-fit: cover;
        width: 100%;
    }
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }
</style>

@endsection