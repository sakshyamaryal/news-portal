<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'News Portal')</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar-top {
            background: #0056b3;
            padding: 10px 0;
            color: #fff;
        }

        .navbar-top .social-icons a {
            font-size: 1.2rem;
            margin: 0 5px;
            color: #dce5f0;
        }

        .navbar-top .social-icons a:hover {
            color: #ffffff;
        }

        .navbar-main {
            background: #003973;
        }

        .navbar-main .navbar-brand {
            font-weight: bold;
            color: #ffffff !important;
        }

        .navbar-main .navbar-nav .nav-link {
            color: #dce5f0 !important;
        }

        .navbar-main .navbar-nav .nav-link:hover {
            color: #ffffff !important;
        }

        .categories-navbar {
            background: #0056b3;
        }

        .categories-navbar .nav-link {
            color: #ffffff;
            font-weight: bold;
            padding: 8px 15px;
        }

        .categories-navbar .nav-link:hover {
            background: #004494;
            color: #ffffff;
        }

        footer {
            background: #003973;
            color: #dce5f0;
        }

        footer a {
            color: #dce5f0;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
            color: #ffffff;
        }

        .social-icons a {
            font-size: 1.5rem;
            margin: 0 0.5rem;
            color: #dce5f0;
        }

        .social-icons a:hover {
            color: #ffffff;
        }

        .btn-primary {
            background: #0056b3;
            border: none;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #004494;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="navbar-top">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Logo -->
                <img src="https://media.istockphoto.com/id/1369150014/vector/breaking-news-with-world-map-background-vector.jpg?s=612x612&w=0&k=20&c=9pR2-nDBhb7cOvvZU_VdgkMmPJXrBQ4rB1AkTXxRIKM=" alt="News Portal Logo" width="70" height="50" class="img-fluid">
            </div>
            <!-- Social Icons -->
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">News Portal</a>
            <button class="navbar-toggler color-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                            <li><a class="dropdown-item" href="{{ url('/category/' . $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/search') }}">All News</a>
                    </li>
                </ul>

                <form class="d-flex me-3" action="{{ url('/search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search news..." aria-label="Search" required>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                @if(auth()->check())
                @if(auth()->user()->hasPermissionTo('dashboard'))
                <a class="btn btn-primary me-2" href="{{ url('/dashboard') }}">Dashboard</a>
                @endif
                <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
                @else
                <a class="btn btn-outline-light me-2" href="{{ url('/login') }}">Login</a>
                <a class="btn btn-primary" href="{{ url('/register') }}">Register</a>
                @endif

            </div>
        </div>
    </nav>


    <nav class="categories-navbar">
        <div class="container">
            <ul class="nav justify-content-center">
                @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/category/' . $category->id) }}">{{ $category->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>Your trusted source for news and updates.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/category') }}">Categories</a></li>
                        <li><a href="{{ url('/search') }}">Search</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Connect With Us</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-light">
            <p>&copy; 2024 News Portal. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>