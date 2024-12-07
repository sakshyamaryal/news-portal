@extends('userlayouts.app')

@section('title', 'Home - News Portal')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <!-- Featured News Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6 position-relative">
                        @if($featuredArticle->images->isNotEmpty())
                            <img src="{{ asset($featuredArticle->images->first()->file_path) }}" 
                                 class="img-fluid w-100 h-100 object-cover" 
                                 alt="{{ $featuredArticle->title }}">
                        @else
                            <img src="https://via.placeholder.com/800x500" 
                                 class="img-fluid w-100 h-100 object-cover" 
                                 alt="{{ $featuredArticle->title }}">
                        @endif
                        <div class="position-absolute top-0 start-0 p-3 bg-primary text-white small">
                            Featured
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body d-flex flex-column h-100">
                            <div>
                                <h3 class="card-title mb-3 fw-bold">{{ $featuredArticle->title }}</h3>
                                <p class="text-muted mb-3">
                                    <i class="bi bi-clock me-2"></i>
                                    {{ $featuredArticle->created_at->format('F j, Y') }} 
                                    · {{ $featuredArticle->author->name }}
                                </p>
                                <p class="card-text text-muted mb-4">
                                    {{ Str::limit($featuredArticle->content, 200) }}
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('article.show', $featuredArticle->id) }}" 
                                   class="btn btn-outline-primary w-100">
                                    Continue Reading
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        

        <!-- Latest Updates Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header  text-white py-3 text-center" style="background-color: #0056b3;">
                    <h5 class="mb-0">Latest Updates</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($latestArticles->take(5) as $article)
                        <a href="{{ route('article.show', $article->id) }}" 
                           class="list-group-item list-group-item-action py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">{{ $article->title }}</h6>
                                <small class="text-muted">
                                    {{ $article->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-1 text-muted small">
                                {{ Str::limit($article->content, 80) }}
                            </p>
                        </a>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>

   

    <!-- Categories Section -->
    <div class="mb-5">
        <h2 class="text-center mb-4 fw-bold">Explore Categories</h2>
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm hover-lift">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" 
                                 class="card-img-top object-cover" 
                                 alt="{{ $category->name }}" 
                                 style="height: 250px;">
                        @else
                            <img src="https://via.placeholder.com/400x250" 
                                 class="card-img-top object-cover" 
                                 alt="{{ $category->name }}" 
                                 style="height: 250px;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title mb-3 fw-bold">{{ $category->name }}</h5>
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($category->description, 120) }}
                            </p>
                            <a href="{{ route('category.articles', $category->id) }}" 
                               class="btn btn-outline-secondary btn-sm">
                                View Articles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-5 text-center">
        @if ($randomAdvertisement && $randomAdvertisement->image_url)
            <img src="{{ $randomAdvertisement->image_url }}" 
                class="img-fluid border rounded" 
                alt="{{ $randomAdvertisement->title ?? 'Advertisement' }}">
        @else
            <img src="https://via.placeholder.com/970x250" 
                class="img-fluid border rounded" 
                alt="Placeholder Advertisement">
        @endif
    </div>

    <!-- Latest Articles Section -->
    <div>
        <h2 class="text-center mb-4 fw-bold">Recent Articles</h2>
        <div class="row g-4">
            @foreach($latestArticles->take(6) as $article)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm hover-lift">
                        @if($article->images->isNotEmpty())
                            <img src="{{ asset($article->images->first()->file_path) }}" 
                                 class="card-img-top object-cover" 
                                 alt="{{ $article->title }}" 
                                 style="height: 250px;">
                        @else
                            <img src="https://via.placeholder.com/400x250" 
                                 class="card-img-top object-cover" 
                                 alt="{{ $article->title }}" 
                                 style="height: 250px;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-bold">{{ $article->title }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-clock me-2"></i>
                                {{ $article->created_at->format('F j, Y') }} 
                                · {{ $article->author->name }}
                            </p>
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($article->content, 100) }}
                            </p>
                            <a href="{{ route('article.show', $article->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
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