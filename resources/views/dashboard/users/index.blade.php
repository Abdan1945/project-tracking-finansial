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
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary shadow-sm" style="border-radius: 8px;">
                <i class="bx bx-user-plus me-1"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- User Table Section --}}
    <div class="card shadow-none border" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($users as $index => $user)
                    <tr>
                        <td class="text-center text-muted">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper me-3">
                                    <div class="avatar avatar-sm">
                                        <span class="avatar-initial rounded-circle {{ $user->role === 'admin' ? 'bg-label-primary' : 'bg-label-info' }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-heading">{{ $user->name }}</span>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-label-primary' : 'bg-label-secondary' }} rounded-pill">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted"><i class="bx bx-calendar-alt me-1"></i> {{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-sm btn-icon btn-outline-primary me-2" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                
                                @if(!($loop->first && $user->role === 'admin'))
                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Hapus user ini?')" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/man-with-laptop-light.png" width="120" alt="empty">
                            <h6 class="mt-3">Belum ada data pengguna yang tersedia.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
        <small class="text-muted">
            Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
        </small>
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
    /* Styling agar serasi dengan Sneat */
    .table thead th { text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    .bg-label-info { background-color: #d7f5fc !important; color: #03c3ec !important; }
    .btn-outline-primary:hover { background-color: #696cff !important; color: #fff !important; }
    
    /* Pagination Fix */
    nav[role="navigation"] svg { width: 20px; }
    .pagination { margin-bottom: 0; }
</style>
@endsection