@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Header Section --}}
    <div class="row align-items-center mb-5 animate__animated animate__fadeIn">
        <div class="col-md-8">
            <h2 class="display-6 fw-black text-dark mb-1 tracking-tight">Financial Intelligence</h2>
            <p class="text-muted fw-medium mb-0">Pantau arus kas dan efisiensi pengeluaran Anda secara real-time.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-flex gap-2 justify-content-md-end">
                <button class="btn btn-white border shadow-sm px-4 fw-bold text-uppercase tracking-wider" style="border-radius: 12px; font-size: 11px;">
                    Export Report
                </button>
                <a href="{{ route('dashboard.transaksi.index') }}" class="btn btn-primary shadow-primary px-4 fw-bold text-uppercase tracking-wider" style="border-radius: 12px; font-size: 11px; background: #696cff !important;">
                    + Transaksi Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards Section --}}
    <div class="row mb-5 animate__animated animate__fadeIn">
        {{-- Card Pemasukan --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100 hover-up" style="border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded-3 bg-label-success p-2">
                                <i class='bx bx-trending-up fs-3'></i>
                            </span>
                        </div>
                        <span class="badge bg-label-success rounded-pill fw-black px-3" style="font-size: 9px;">INCOME</span>
                    </div>
                    <p class="text-muted fw-bold text-uppercase tracking-widest mb-1" style="font-size: 10px;">Total Pemasukan</p>
                    <h3 class="fw-black mb-0 text-dark">
                        <small class="text-muted fw-light font-italic">Rp</small> 
                        {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Card Pengeluaran --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100 hover-up" style="border-radius: 24px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded-3 bg-label-danger p-2">
                                <i class='bx bx-trending-down fs-3'></i>
                            </span>
                        </div>
                        <span class="badge bg-label-danger rounded-pill fw-black px-3" style="font-size: 9px;">EXPENSE</span>
                    </div>
                    <p class="text-muted fw-bold text-uppercase tracking-widest mb-1" style="font-size: 10px;">Total Pengeluaran</p>
                    <h3 class="fw-black mb-0 text-dark">
                        <small class="text-muted fw-light font-italic">Rp</small> 
                        {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Card Saldo Akhir --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg h-100 position-relative overflow-hidden bg-dark text-white hover-up" style="border-radius: 24px; background: #232333 !important;">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded-3 bg-primary p-2">
                                <i class='bx bx-wallet fs-3'></i>
                            </span>
                        </div>
                        <span class="badge bg-label-primary rounded-pill fw-black px-3" style="font-size: 9px;">NET WORTH</span>
                    </div>
                    <p class="text-light opacity-50 fw-bold text-uppercase tracking-widest mb-1" style="font-size: 10px;">Saldo Akhir</p>
                    <h3 class="fw-black mb-0 text-white">
                        <small class="opacity-50 fw-light font-italic">Rp</small> 
                        {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="position-absolute end-0 bottom-0 p-3 opacity-10">
                    <i class='bx bx-shield-alt-2 display-1'></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Transactions Section --}}
    <div class="card border-0 shadow-sm animate__animated animate__fadeInUp" style="border-radius: 24px;">
        <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between p-4">
            <h5 class="m-0 fw-black text-dark tracking-tight">Transaksi Terakhir</h5>
            <a href="{{ route('dashboard.transaksi.index') }}" class="btn btn-sm btn-label-primary fw-bold text-uppercase px-3" style="font-size: 10px; border-radius: 8px;">
                Lihat Semua
            </a>
        </div>
        <div class="table-responsive text-nowrap p-2">
            <table class="table table-hover align-middle border-0">
                <thead class="bg-light border-0">
                    <tr>
                        <th class="ps-4 text-uppercase fw-black text-muted tracking-widest" style="font-size: 10px; border:none;">Tanggal</th>
                        <th class="text-uppercase fw-black text-muted tracking-widest" style="font-size: 10px; border:none;">Deskripsi / Jenis</th>
                        <th class="text-end pe-4 text-uppercase fw-black text-muted tracking-widest" style="font-size: 10px; border:none;">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($transactions ?? [] as $t)
                    <tr>
                        <td class="ps-4 py-3">
                            <span class="fw-bold text-dark">{{ $t->tanggal->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded-circle {{ $t->jenis == 'pemasukan' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        <i class='bx {{ $t->jenis == 'pemasukan' ? 'bx-plus-circle' : 'bx-minus-circle' }}'></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-dark text-capitalize">
                                        {{-- PERBAIKAN: Ubah 'nama' menjadi 'nama_kategori' --}}
                                        {{ $t->kategori_keuangan->nama_kategori ?? 'Tanpa Kategori' }}
                                    </p>
                                    <small class="text-muted text-uppercase fw-medium" style="font-size: 9px;">
                                        {{-- Jika ingin menampilkan nama Akun Keuangan (Bank/Cash) di bawah kategori --}}
                                        {{ $t->akun_keuangan->nama_akun ?? $t->jenis }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <h6 class="mb-0 fw-black {{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </h6>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="opacity-25 my-4">
                                <i class='bx bx-data display-1'></i>
                                <p class="fw-bold text-uppercase tracking-widest mt-2" style="font-size: 10px;">Belum ada data transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Reset & Luxury Overrides */
    .fw-black { font-weight: 900 !important; }
    .tracking-tight { letter-spacing: -0.5px; }
    .tracking-widest { letter-spacing: 1.5px !important; }
    .hover-up { transition: all 0.3s ease; }
    .hover-up:hover { transform: translateY(-8px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
    
    .bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }
    .bg-label-danger { background-color: #ffe5e5 !important; color: #ff3e1d !important; }
    .bg-label-primary { background-color: #e7e7ff !important; color: #696cff !important; }
    
    .table > :not(caption) > * > * { border-bottom-width: 0; padding: 1rem 0.5rem; }
</style>
@endsection