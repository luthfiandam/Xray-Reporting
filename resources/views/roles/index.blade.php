@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-shield"></i> Manajemen Role
            </h1>
            <p class="text-muted mt-2">Kelola role dan akses sistem</p>
        </div>
        <div class="col-md-4 text-end">
            @can('create', App\Models\Role::class)
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Role
                </a>
            @endcan
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Role</small>
                            <h5 class="mb-0">{{ $stats['total_roles'] }}</h5>
                        </div>
                        <i class="fas fa-shield-alt fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Aktif</small>
                            <h5 class="mb-0">{{ $stats['active_roles'] }}</h5>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Nonaktif</small>
                            <h5 class="mb-0">{{ $stats['inactive_roles'] }}</h5>
                        </div>
                        <i class="fas fa-times-circle fa-2x text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Memiliki User</small>
                            <h5 class="mb-0">{{ $stats['roles_with_users'] }}</h5>
                        </div>
                        <i class="fas fa-users fa-2x text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('roles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Cari nama atau deskripsi..." 
                        value="{{ $filters['search'] ?? '' }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="is_active" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="1" @selected($filters['is_active'] === '1')>Aktif</option>
                        <option value="0" @selected($filters['is_active'] === '0')>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="sort_by" class="form-select">
                        <option value="created_at" @selected($sort_by === 'created_at')>Terbaru</option>
                        <option value="name" @selected($sort_by === 'name')>Nama</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th>
                            <a href="{{ route('roles.index', array_merge($filters, ['sort_by' => 'name', 'sort_dir' => $sort_dir === 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none">
                                Nama Role
                                @if ($sort_by === 'name')
                                    <i class="fas fa-sort-{{ $sort_dir === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Deskripsi</th>
                        <th style="width: 10%">Jumlah User</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</td>
                            <td>
                                <strong>{{ $role->name }}</strong>
                            </td>
                            <td>
                                {{ $role->description ?? '-' }}
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $role->users()->count() }} user
                                </span>
                            </td>
                            <td>
                                @if ($role->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('update', $role)
                                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('deactivate', $role)
                                        @if ($role->is_active)
                                            <form action="{{ route('roles.deactivate', $role) }}" method="POST" style="display: inline;" onclick="return confirm('Yakin nonaktifkan role ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Nonaktifkan">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('roles.activate', $role) }}" method="POST" style="display: inline;" onclick="return confirm('Yakin aktifkan role ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm" title="Aktifkan">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                <p class="text-muted">Tidak ada role ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($roles->hasPages())
            <div class="card-footer bg-light">
                {{ $roles->links('pagination::bootstrap-4') }}
            </div>
        @endif
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