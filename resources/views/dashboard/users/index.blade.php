@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Header Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Manajemen /</span> Pengguna
            </h4>
            <p class="text-muted">Kelola akses sistem dan akun pengguna dalam satu panel.</p>
        </div>
        <div class="col-md-6 text-md-end">
            {{-- Tombol Biru Solid Bawaan Sneat --}}
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary btn-lg shadow-sm" style="border-radius: 12px;">
                <i class="bx bx-user-plus me-1"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- User List Section --}}
    <div class="row">
        @forelse ($users as $index => $user)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-none border hover-shadow transition-all" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        {{-- Avatar Icon --}}
                        <div class="avatar avatar-md flex-shrink-0">
                            <span class="avatar-initial rounded-circle {{ $user->role === 'admin' ? 'bg-label-primary' : 'bg-label-info' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        {{-- Badge Role --}}
                        <span class="badge {{ $user->role === 'admin' ? 'bg-label-primary' : 'bg-label-secondary' }} rounded-pill">
                            {{ strtoupper($user->role) }}
                        </span>
                    </div>

                    <h5 class="card-title mb-1 fw-bold">{{ $user->name }}</h5>
                    <p class="card-text text-muted small mb-3">
                        <i class="bx bx-envelope me-1"></i> {{ $user->email }}<br>
                        <i class="bx bx-calendar me-1"></i> Terdaftar: {{ $user->created_at->format('d M Y') }}
                    </p>

                    <hr class="my-3 opacity-50">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="action-buttons">
                            <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="bx bx-edit-alt"></i> Edit
                            </a>
                            
                            @if(!($loop->first && $user->role === 'admin'))
                            <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user ini?')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                        <small class="text-muted">#{{ $users->firstItem() + $index }}</small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/man-with-laptop-light.png" width="150" alt="empty">
            <h5 class="mt-3">Belum ada pengguna</h5>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div>

<style>
    /* Mengatasi konflik CSS agar tidak "jelek" lagi */
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border-color: #696cff !important;
        transition: all 0.3s ease;
    }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
    .btn-primary { background-color: #696cff !important; border-color: #696cff !important; }
    
    /* Perbaikan Pagination */
    nav[role="navigation"] svg { width: 20px; }
    .pagination { justify-content: center; }
</style>
@endsection