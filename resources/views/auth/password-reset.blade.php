@extends('layouts.auth')

@section('title', 'Reset Password - Xray Reporting App')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100">
        <div class="col-md-6 col-lg-5 mx-auto">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-key me-2"></i>Reset Password
                    </h2>
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
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Reset Form -->
                    <form method="POST" action="{{ route('password.reset') }}" class="needs-validation">
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

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">
                                <i class="fas fa-lock me-2"></i>Password Saat Ini
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg @error('current_password') is-invalid @enderror" 
                                id="current_password" 
                                name="current_password" 
                                placeholder="Masukkan password saat ini"
                                required
                            >
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">
                                <i class="fas fa-lock me-2"></i>Password Baru
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg @error('new_password') is-invalid @enderror" 
                                id="new_password" 
                                name="new_password" 
                                placeholder="Masukkan password baru (minimal 8 karakter)"
                                required
                            >
                            @error('new_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-bold">
                                <i class="fas fa-lock me-2"></i>Konfirmasi Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                placeholder="Konfirmasi password baru"
                                required
                            >
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">
                            <i class="fas fa-sync me-2"></i>Reset Password
                        </button>
                    </form>

                    <!-- Footer Links -->
                    <div class="mt-4 text-center">
                        <p class="text-muted">
                            Kembali ke 
                            <a href="{{ route('login') }}" class="text-primary fw-bold">
                                Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection