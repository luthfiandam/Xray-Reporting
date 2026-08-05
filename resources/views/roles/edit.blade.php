@extends('layouts.app')

@section('title', 'Edit Role - ' . $role->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-edit"></i> Edit Role: <strong>{{ $role->name }}</strong>
            </h1>
            <p class="text-muted mt-2">
                Ubah detail role
                <span class="badge bg-{{ $role->is_active ? 'success' : 'danger' }}">
                    {{ $role->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @include('roles.partials.form', ['role' => $role])
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-history"></i> Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">ID</small>
                        <p class="mb-0"><code>{{ $role->id }}</code></p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Jumlah User</small>
                        <p class="mb-0">
                            <span class="badge bg-primary">
                                {{ $role->users()->count() }} user terdaftar
                            </span>
                        </p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted">Dibuat Pada</small>
                        <p class="mb-0">{{ $role->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Diperbarui Pada</small>
                        <p class="mb-0">{{ $role->updated_at->format('d M Y H:i') }}</p>
                    </div>

                    <hr>

                    @if ($role->users()->count() > 0)
                        <div class="alert alert-info small mb-0">
                            <i class="fas fa-info-circle"></i>
                            Role ini tidak dapat dihapus karena masih memiliki user terdaftar.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection