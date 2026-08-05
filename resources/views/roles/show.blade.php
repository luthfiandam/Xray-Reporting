@extends('layouts.app')

@section('title', 'Detail Role - ' . $role->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-shield-alt"></i> {{ $role->name }}
            </h1>
            <p class="text-muted mt-2">Detail informasi role</p>
        </div>
        <div class="col-md-4 text-end">
            @can('update', $role)
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan
        </div>
    </div>

    @if ($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Role
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <small class="text-muted">Nama Role</small>
                            <p class="mb-0">
                                <strong>{{ $role->name }}</strong>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                @if ($role->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i> Nonaktif
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Jumlah User</small>
                            <p class="mb-0">
                                <span class="badge bg-info">
                                    {{ $role->users()->count() }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">ID Role</small>
                            <p class="mb-0"><code>{{ $role->id }}</code></p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-0">
                        <small class="text-muted">Deskripsi</small>
                        <p class="mb-0">
                            {{ $role->description ?? '<em class="text-muted">Tidak ada deskripsi</em>' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-users"></i> User dengan Role Ini
                    </h6>
                </div>
                <div class="card-body">
                    @if ($role->users()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Terakhir Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($role->users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                            </td>
                                            <td>{{ $user->username }}</td>
                                            <td>
                                                @if ($user->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->last_login_at)
                                                    {{ $user->last_login_at->diffForHumans() }}
                                                @else
                                                    <span class="text-muted">Belum pernah</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Tidak ada user dengan role ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-clock"></i> Timestamps
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Dibuat Pada</small>
                        <p class="mb-0">
                            <small>{{ $role->created_at->format('d M Y H:i:s') }}</small>
                        </p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Diperbarui Pada</small>
                        <p class="mb-0">
                            <small>{{ $role->updated_at->format('d M Y H:i:s') }}</small>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs"></i> Aksi
                    </h6>
                </div>
                <div class="card-body">
                    @can('update', $role)
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-edit"></i> Edit Role
                        </a>
                    @endcan

                    @can('deactivate', $role)
                        @if ($role->is_active)
                            <form action="{{ route('roles.deactivate', $role) }}" method="POST" id="deactivateForm">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 mb-2" onclick="return confirm('Yakin nonaktifkan role ini?')">
                                    <i class="fas fa-ban"></i> Nonaktifkan Role
                                </button>
                            </form>
                        @else
                            <form action="{{ route('roles.activate', $role) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Yakin aktifkan role ini?')">
                                    <i class="fas fa-check"></i> Aktifkan Role
                                </button>
                            </form>
                        @endif
                    @endcan

                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if (!$canDelete)
                <div class="alert alert-info mt-3 small">
                    <i class="fas fa-info-circle"></i>
                    <strong>Catatan:</strong> Role ini tidak dapat dihapus karena masih memiliki user terdaftar.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
</script>
@endsection