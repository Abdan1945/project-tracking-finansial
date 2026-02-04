@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    {{-- Header & Breadcrumb --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-1">Detail Kategori</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.kategori-keuangan.index') }}" class="text-decoration-none text-indigo-600">Kategori</a></li>
                    <li class="breadcrumb-item active">#{{ $kategori->id }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="btn btn-white border shadow-sm rounded-xl px-4 fw-bold">
            <i class='bx bx-arrow-back me-1'></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- Card Utama --}}
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm rounded-[2.5rem] overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="w-24 h-24 bg-indigo-50 text-indigo-600 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class='bx bx-category-alt display-4'></i>
                        </div>
                        <h3 class="fw-black text-slate-800 mb-1">{{ $kategori->nama_kategori }}</h3>
                        <span class="badge {{ $kategori->jenis == 'pemasukan' ? 'bg-label-success' : 'bg-label-danger' }} rounded-pill px-4 py-2 mt-2 fw-black tracking-widest" style="font-size: 10px;">
                            {{ strtoupper($kategori->jenis) }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-2xl">
                            <span class="text-slate-400 font-bold text-uppercase tracking-widest" style="font-size: 10px;">ID Kategori</span>
                            <span class="fw-black text-slate-700">#{{ $kategori->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <span class="text-slate-400 font-medium">Tanggal Dibuat</span>
                            <span class="fw-bold text-slate-700">{{ $kategori->created_at->format('d F Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <span class="text-slate-400 font-medium">Waktu Input</span>
                            <span class="fw-bold text-slate-700">{{ $kategori->created_at->format('H:i') }} WIB</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <a href="{{ route('dashboard.kategori-keuangan.edit', $kategori->id) }}" class="btn btn-primary btn-lg rounded-2xl shadow-primary py-3 fw-bold">
                            <i class='bx bx-edit-alt me-1'></i> Edit Kategori
                        </a>
                        <form action="{{ route('dashboard.kategori-keuangan.destroy', $kategori->id) }}" method="POST" class="m-0 d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-label-danger btn-lg rounded-2xl py-3 fw-bold" onclick="return confirm('Hapus kategori ini?')">
                                <i class='bx bx-trash me-1'></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Visual/Insights --}}
        <div class="col-md-7 mb-4">
            <div class="bg-dark rounded-[2.5rem] p-5 text-white h-100 position-relative overflow-hidden" style="background: #232333 !important;">
                <div class="position-relative z-index-1">
                    <h4 class="fw-black mb-4">Informasi Tambahan</h4>
                    <p class="text-light opacity-50 mb-5">Kategori ini digunakan untuk memisahkan setiap arus kas agar laporan keuangan Anda lebih terstruktur.</p>
                    
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="p-4 rounded-3xl bg-white/5 border border-white/10">
                                <i class='bx bx-check-shield text-success display-6 mb-3'></i>
                                <h6 class="text-white fw-bold mb-1">Status Kategori</h6>
                                <p class="small opacity-50 mb-0">Aktif & Terverifikasi</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-4 rounded-3xl bg-white/5 border border-white/10">
                                <i class='bx bx-user-circle text-info display-6 mb-3'></i>
                                <h6 class="text-white fw-bold mb-1">Pemilik</h6>
                                <p class="small opacity-50 mb-0">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 p-4 bg-indigo-600/20 rounded-3xl border border-indigo-500/30">
                        <div class="d-flex align-items-start gap-3">
                            <i class='bx bx-bulb fs-2 text-warning'></i>
                            <div>
                                <p class="mb-0 small fw-bold">Tips Keuangan:</p>
                                <p class="mb-0 small opacity-75">Gunakan nama kategori yang spesifik (misal: "Gaji Pokok" daripada hanya "Pemasukan") untuk analisis yang lebih tajam.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ornamen --}}
                <div class="position-absolute end-0 bottom-0 p-3 opacity-10">
                    <i class='bx bx-chart display-1'></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900 !important; }
    .bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }
    .bg-label-danger { background-color: #ffe5e5 !important; color: #ff3e1d !important; }
    .shadow-primary { box-shadow: 0 8px 25px -5px rgba(105, 108, 255, 0.4) !important; }
    .z-index-1 { position: relative; z-index: 1; }
</style>
@endsection