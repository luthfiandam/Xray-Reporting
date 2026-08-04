@extends('layouts.auth')

@section('title', 'Login - Xray Reporting App')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100">
        <div class="col-md-6 col-lg-5 mx-auto">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-x-ray me-2"></i>Xray Reporting App
                    </h2>
                    <small class="text-light">Sistem Preventive Maintenance</small>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <!-- Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="needs-validation">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input 
                                type="email" 
                                class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="Masukkan email Anda"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Masukkan password Anda"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="remember" 
                                name="remember"
                            >
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>

                    <!-- Footer Links -->
                    <div class="mt-4 text-center">
                        <p class="text-muted mb-2">
                            Lupa password? 
                            <a href="{{ route('password.reset') }}" class="text-primary fw-bold">
                                Reset di sini
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>
                        Login Anda aman dan terlindungi
                    </small>
                </div>
            </div>

            <!-- Demo Credentials (Development Only) -->
            @if (app()->environment('local'))
                <div class="alert alert-info mt-3 small">
                    <strong>Demo Credentials:</strong><br>
                    Email: <code>admin@xray.local</code><br>
                    Password: <code>admin123</code>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .min-vh-100 {
        min-height: 100vh;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    .form-control-lg:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
</style>
@endsection