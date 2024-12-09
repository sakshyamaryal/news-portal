@extends('userlayouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <!-- <a href="{{ url('/password/reset') }}" class="text-muted">Forgot Password?</a> -->
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Don't have an account? <a href="{{ url('/register') }}" class="text-primary">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    body {
        background-color: #f4f7fa;
    }
    .card {
        border-radius: 8px;
        border: none;
    }
    .card-header {
        border-radius: 8px 8px 0 0;
    }
    .card-footer {
        background-color: #f8f9fa;
        border-radius: 0 0 8px 8px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    .text-muted {
        font-size: 0.9rem;
    }
</style>

@endsection
