<div class="card">
    <div class="card-body">
        <form 
            action="{{ $role->exists ? route('roles.update', $role) : route('roles.store') }}" 
            method="POST" 
            id="roleForm"
        >
            @csrf
            @if ($role->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">
                    Nama Role <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    placeholder="Contoh: SUPER ADMIN, TEKNISI, SUPERVISOR"
                    value="{{ old('name', $role->name ?? '') }}"
                    required
                    maxlength="50"
                >
                @error('name')
                    <div class="invalid-feedback d-block">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted">Maksimal 50 karakter</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">
                    Deskripsi <span class="text-muted">(Opsional)</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control @error('description') is-invalid @enderror" 
                    rows="4"
                    placeholder="Jelaskan tugas dan tanggung jawab role ini..."
                    maxlength="255"
                >{{ old('description', $role->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted">Maksimal 255 karakter</small>
            </div>

            <div class="mb-3">
                <div class="form-check form-switch">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1"
                        @checked(old('is_active', $role->is_active ?? true))
                    >
                    <label class="form-check-label" for="is_active">
                        Status Aktif
                    </label>
                </div>
                <small class="form-text text-muted d-block mt-2">
                    Nonaktifkan jika role tidak lagi digunakan
                </small>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="reset" class="btn btn-outline-warning">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> 
                    {{ $role->exists ? 'Perbarui Role' : 'Buat Role' }}
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('roleForm').addEventListener('submit', function(e) {
        const nameInput = document.getElementById('name');
        if (!nameInput.value.trim()) {
            e.preventDefault();
            nameInput.classList.add('is-invalid');
            return false;
        }
    });

    document.getElementById('name').addEventListener('blur', function() {
        this.value = this.value.toUpperCase().trim();
    });
</script>
@endsection