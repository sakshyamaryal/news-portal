@extends('userlayouts.app')

@section('title', $article->title)

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="row">
        <!-- Main Article Section -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm">
                <div class="card-body p-lg-5">
                    <!-- Article Header -->
                    <header class="mb-4 text-center">
                        <h1 class="display-5 fw-bold mb-3">{{ $article->title }}</h1>
                        <div class="d-flex justify-content-center align-items-center text-muted mb-4">
                            <div class="d-flex align-items-center me-4">
                                <i class="bi bi-person-circle me-2"></i>
                                <span>{{ $article->author->name }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar me-2"></i>
                                <time datetime="{{ $article->created_at->toIso8601String() }}">
                                    {{ $article->created_at->format('F j, Y') }}
                                </time>
                            </div>
                        </div>
                    </header>

                    <!-- Article Images Section -->
                    @if($article->images->isNotEmpty())
                    <div class="article-gallery mb-4">
                        <!-- Main Featured Image -->
                        <div class="featured-image mb-4">
                            <img src="{{ asset($article->images->first()->file_path) }}" alt="Main Article Image" class="img-fluid rounded-3 shadow-sm w-100">
                        </div>

                        <!-- Additional Images -->
                        @if($article->images->count() > 1)
                        <div class="additional-images d-flex gap-3 overflow-auto pb-3">
                            @foreach($article->images->slice(1) as $image)
                            <div class="additional-image flex-shrink-0" style="width: 150px; height: 100px;">
                                <img src="{{ asset($image->file_path) }}" alt="Article Image" class="img-fluid rounded-2 object-cover h-100 w-100">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        <p class="lead text-muted mb-4">
                            {{ Str::limit($article->excerpt, 250, '...') }}
                        </p>

                        <div class="content-body">
                            {!! nl2br(e($article->content)) !!}
                        </div>
                    </div>
                </div>
            </article>

            <div id="comment-section" class="mt-5">
                <h3 class="mb-4 fw-bold">Comments ({{ $article->comments->count() }})</h3>

                <!-- Comment Form -->
                @auth
                <form id="comment-form" method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <div class="mb-3">
                        <textarea class="form-control" name="content" rows="4" placeholder="Add your comment here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                @else
                <p class="text-muted">Please <a href="{{ url('/login') }}">log in</a> to leave a comment.</p>
                @endauth

                <!-- Display Comments -->
                <div id="comment-list" class="mt-4">
                    @foreach($article->comments as $comment)
                    <div class="comment-item mb-4" id="comment-{{ $comment->id }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="avatar">
                                <!-- <img src="{{  'https://via.placeholder.com/50' }}" alt="User Avatar" class="rounded-circle" width="50" height="50"> -->
                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #0056b3; color: white; font-weight: bold; font-size: 18px;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>

                            </div>
                            <div class="comment-body">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="comment-content mb-2">{{ $comment->content }}</p>

                                @if(auth()->check() && auth()->id() === $comment->user_id)
                                <div class="d-flex gap-2 justify-content-end">
                                    <button class="btn btn-sm btn-outline-secondary edit-btn" data-id="{{ $comment->id }}" title="Edit">
                                        <i class="fa fa-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $comment->id }}" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <style>
                 #comment-list {
                    max-height: 400px;
                    overflow-y: scroll;
                    scrollbar-gutter: stable; 
                    padding-right: 10px;
                }
                #comment-section h3 {
                    font-size: 1.5rem;
                    border-bottom: 2px solid #0056b3;
                    display: inline-block;
                    padding-bottom: 0.25rem;
                }

                .comment-item {
                    border-bottom: 1px solid #eee;
                    padding-bottom: 1rem;
                    margin-bottom: 1rem;
                }

                .avatar img {
                    border: 2px solid #0056b3;
                }

                .comment-body {
                    flex-grow: 1;
                }

                .comment-content {
                    font-size: 1rem;
                    line-height: 1.5;
                }

                .btn-outline-secondary {
                    color: #6c757d;
                    border-color: #6c757d;
                }

                .btn-outline-secondary:hover {
                    background-color: #6c757d;
                    color: white;
                }

                .btn-outline-danger:hover {
                    background-color: #dc3545;
                    color: white;
                }
            </style>

            <!-- Related Articles Section -->
            <section class="mt-5">
                <h3 class="mb-4 fw-bold text-center">Related Articles</h3>
                <div class="row g-4">
                    @foreach($relatedArticles->take(3) as $relatedArticle)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm hover-lift">
                            @if($relatedArticle->images->isNotEmpty())
                            <img src="{{ asset($relatedArticle->images->first()->file_path) }}" class="card-img-top object-cover" alt="{{ $relatedArticle->title }}" style="height: 200px;">
                            @else
                            <img src="https://via.placeholder.com/400x250" class="card-img-top object-cover" alt="{{ $relatedArticle->title }}" style="height: 200px;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title mb-2 fw-bold">
                                    {{ Str::limit($relatedArticle->title, 50) }}
                                </h5>
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-clock me-2"></i>
                                    {{ $relatedArticle->created_at->diffForHumans() }}
                                </p>
                                <a href="{{ route('article.show', $relatedArticle->id) }}" class="btn btn-outline-primary btn-sm">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Sidebar Section -->
        <div class="col-lg-4">
            <!-- Categories Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header text-white py-3 text-center" style="background-color: #0056b3;">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                    <a href="{{ route('category.articles', $category->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                        {{ $category->name }}
                        <span class="badge bg-primary rounded-pill">
                            {{ $category->articles_count }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>



            <!-- Most Read Articles -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white py-3 text-center">
                    <h5 class="mb-0">Most Read</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($mostReadArticles->take(5) as $popularArticle)
                    <a href="{{ route('article.show', $popularArticle->id) }}" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-bold">
                                {{ Str::limit($popularArticle->title, 50) }}
                            </h6>
                            <small class="text-muted">
                                {{ $popularArticle->view_count }} views
                            </small>
                        </div>
                    </a>
                    @endforeach
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
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
    }

    .content-body p {
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .additional-images::-webkit-scrollbar {
        height: 8px;
    }

    .additional-images::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .additional-images::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.js"></script>

<script>
    const generateUniqueId = () => `comment-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;

    // Helper to handle errors
    const handleError = async (response) => {
        if (!response.ok) {
            const error = await response.json();
            throw error.message || "Something went wrong!";
        }
        return response.json();
    };

    // Realtime Comment Actions
    const editComment = async (commentId) => {
        const commentItem = document.getElementById(`comment-${commentId}`);
        const commentContent = commentItem.querySelector('.comment-content');
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');

        // Create a textarea for editing
        const textarea = document.createElement('textarea');
        textarea.classList.add('form-control');
        textarea.rows = 4;
        textarea.textContent = commentContent.textContent.trim();

        commentContent.replaceWith(textarea);
        const editButton = commentItem.querySelector('.edit-btn');
        const saveButton = document.createElement('button');
        saveButton.classList.add('btn', 'btn-sm', 'btn-outline-success');
        saveButton.textContent = 'Save';
        commentItem.querySelector('.comment-body').appendChild(saveButton);

        editButton.style.display = 'none';

        saveButton.addEventListener('click', async () => {
            const newContent = textarea.value.trim();
            if (!newContent) return;

            try {
                const response = await fetch(`/api/comments/${commentId}`, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        content: newContent
                    }),
                });

                const data = await handleError(response);
                toastr.success(data.message);

                // Replace the textarea with the updated comment content
                const updatedComment = document.createElement('p');
                updatedComment.classList.add('comment-content', 'mb-2');
                updatedComment.textContent = data.comment.content;
                textarea.replaceWith(updatedComment);
                saveButton.remove();
                editButton.style.display = 'inline-block';

            } catch (err) {
                toastr.error(err);
            }
        });
    };

    const deleteComment = async (commentId) => {
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');

        const result = await Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/api/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json',
                    },
                });

                const data = await handleError(response);
                toastr.success(data.message);
                document.getElementById(`comment-${commentId}`).remove();
            } catch (err) {
                toastr.error(err);
            }
        }
    };

    document.querySelector('#comment-list').addEventListener('click', async function(e) {
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        if (editBtn) {
            const commentId = editBtn.dataset.id;
            editComment(commentId);
        }
        if (deleteBtn) {
            const commentId = deleteBtn.dataset.id;
            deleteComment(commentId);
        }
    });


    // Add Comment in Realtime
    document.getElementById('comment-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': `Bearer ${bearerToken}`,
                },
            });

            const data = await handleError(response);

            toastr.success(data.message);
            form.reset();

            // Append the new comment without refreshing
            const uniqueId = generateUniqueId();
            const commentSection = document.querySelector('#comment-list');
            commentSection.insertAdjacentHTML(
                'afterbegin',
                `<div class="comment-item mb-4" id="${uniqueId}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="avatar">
                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #0056b3; color: white; font-weight: bold; font-size: 18px;">
                            ${data.username.charAt(0).toUpperCase()}
                        </div>

                        </div>
                        <div class="comment-body">
                            <div class="d-flex justify-content-between">
                                <strong>${data.username}</strong>
                                <span class="text-muted small">Just now</span>
                            </div>
                            <p class="comment-content mb-2">${data.comment.content}</p>
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-sm btn-outline-secondary edit-btn" data-id="${data.comment.id}" title="Edit">
                                    <i class="fa fa-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${data.comment.id}" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>`
            );
        } catch (err) {
            toastr.error(err);
        }
    });
</script>

@endsection