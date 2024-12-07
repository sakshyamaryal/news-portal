@extends('userlayouts.app')

@section('title', $category->name . ' - News Portal')

@section('content')
    <div class="container mt-5">
        <h3 class="text-center mb-4">{{ $category->name }} Articles</h3>
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card news-card">
                        <!-- Dynamic article image -->
                        @if($article->images->isNotEmpty())
                            <img src="{{ asset($article->images->first()->file_path) }}" class="card-img-top" alt="{{ $article->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="{{ $article->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                            <a href="{{ route('article.show', $article->id) }}" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
