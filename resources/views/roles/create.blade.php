@extends('layouts.app')

@section('title', 'Tambah Role')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus-circle"></i> Tambah Role Baru
            </h1>
            <p class="text-muted mt-2">Buat role baru untuk sistem</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @include('roles.partials.form', ['role' => new App\Models\Role()])
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Panduan
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nama Role:</strong></p>
                    <ul class="small">
                        <li>Gunakan huruf besar</li>
                        <li>Maks 50 karakter</li>
                        <li>Harus unik</li>
                        <li>Contoh: SUPER ADMIN, TEKNISI</li>
                    </ul>

                    <hr>

                    <p class="mb-2"><strong>Deskripsi:</strong></p>
                    <ul class="small">
                        <li>Jelaskan fungsi role</li>
                        <li>Sebutkan tugas utama</li>
                        <li>Opsional tapi sangat membantu</li>
                    </ul>

                    <hr>

                    <p class="mb-2"><strong>Status Aktif:</strong></p>
                    <ul class="small">
                        <li>Checklist = Role aktif</li>
                        <li>Unchecklist = Role nonaktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection