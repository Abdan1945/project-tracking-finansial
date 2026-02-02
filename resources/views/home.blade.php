@extends('layouts.dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    :root { --primary-font: 'Plus Jakarta Sans', sans-serif; --soft-bg: #f8f9fc; }
    body { font-family: var(--primary-font); background-color: var(--soft-bg); color: #2d3436; }
    
    .stat-card { border: none; border-radius: 24px; transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important; }

    .bg-gradient-expense { background: linear-gradient(135deg, #ff8a71 0%, #ee5253 100%); }
    .bg-gradient-income { background: linear-gradient(135deg, #4ee3ae 0%, #10b981 100%); }
    .bg-gradient-balance { background: linear-gradient(135deg, #818cf8 0%, #4f46e5 100%); }

    .glass-icon { width: 48px; height: 48px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); border-radius: 14px; display: flex; align-items: center; justify-content: center; }
    
    .chart-box { border-radius: 24px; background: #fff; padding: 24px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }

    .custom-table { border-collapse: separate; border-spacing: 0 10px; }
    .custom-table tr { background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.02); border-radius: 12px; }
    .custom-table td { border: none; padding: 15px; }
    
    .btn-label-success { background: #e6f7f0; color: #10b981; }
    .btn-label-danger { background: #fef2f2; color: #ee5253; }
    .btn-label-secondary { background: #f1f5f9; color: #64748b; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    {{-- Baris Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
            <div class="card stat-card bg-gradient-expense text-white shadow">
                <div class="card-body p-4">
                    <div class="glass-icon mb-3"><i class="bx bx-trending-down fs-3"></i></div>
                    <p class="mb-1 opacity-75 fw-medium">Total Pengeluaran</p>
                    <h3 class="text-white fw-bold mb-0">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card stat-card bg-gradient-income text-white shadow">
                <div class="card-body p-4">
                    <div class="glass-icon mb-3"><i class="bx bx-trending-up fs-3"></i></div>
                    <p class="mb-1 opacity-75 fw-medium">Total Pemasukan</p>
                    <h3 class="text-white fw-bold mb-0">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12" data-aos="fade-up" data-aos-delay="200">
            <div class="card stat-card bg-gradient-balance text-white shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="glass-icon"><i class="bx bx-wallet fs-3"></i></div>
                        <span class="badge bg-white text-primary rounded-pill px-3">Net Worth</span>
                    </div>
                    <p class="mb-1 opacity-75 fw-medium">Saldo Akhir</p>
                    <h2 class="text-white fw-bold mb-0">Rp {{ number_format($total_saldo, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik dan Aksi Cepat --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="chart-box h-100">
                <h5 class="fw-bold mb-4">Analisis Arus Kas Bulanan</h5>
                <div style="height: 300px;"><canvas id="cashFlowChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4" data-aos="fade-left">
            <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
                <h5 class="fw-bold mb-4">Aksi Cepat</h5>
                <div class="d-grid gap-3">
                    <button class="btn btn-label-success py-3 rounded-3 border-0 text-start d-flex align-items-center">
                        <i class="bx bx-plus-circle fs-4 me-3"></i> 
                        <div><b class="d-block">Pemasukan</b><small>Catat uang masuk</small></div>
                    </button>
                    <button class="btn btn-label-danger py-3 rounded-3 border-0 text-start d-flex align-items-center">
                        <i class="bx bx-minus-circle fs-4 me-3"></i> 
                        <div><b class="d-block">Pengeluaran</b><small>Catat uang keluar</small></div>
                    </button>
                    <button class="btn btn-label-secondary py-3 rounded-3 border-0 text-start d-flex align-items-center">
                        <i class="bx bx-file fs-4 me-3"></i> 
                        <div><b class="d-block">Ekspor Laporan</b><small>PDF / Excel</small></div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">Riwayat Transaksi Terakhir</h5>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th class="ps-4">DESKRIPSI</th>
                            <th>KATEGORI</th>
                            <th>TANGGAL</th>
                            <th class="text-end pe-4">JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3 bg-light rounded-pill p-2 text-center" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx {{ $trx->jenis == 'pemasukan' ? 'bx-up-arrow-alt text-success' : 'bx-down-arrow-alt text-danger' }} fs-4"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block">{{ $trx->keterangan ?? 'Tanpa Keterangan' }}</span>
                                        <small class="text-muted text-capitalize">{{ $trx->jenis }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary rounded-pill px-3">
                                    {{ $trx->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="text-muted fw-medium">{{ $trx->tanggal->format('d M Y') }}</td>
                            <td class="text-end pe-4 fw-bold {{ $trx->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                {{ $trx->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bx bx-receipt fs-1 d-block mb-2"></i>
                                Belum ada data transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Animasi
        AOS.init({ duration: 800, once: true });

        // Inisialisasi Grafik
        const ctx = document.getElementById('cashFlowChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($grafik_data->pluck('bulan')) !!},
                datasets: [
                    { 
                        label: 'Masuk', 
                        data: {!! json_encode($grafik_data->pluck('masuk')) !!}, 
                        borderColor: '#10b981', 
                        backgroundColor: 'rgba(16, 185, 129, 0.1)', 
                        fill: true, 
                        tension: 0.4, 
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981'
                    },
                    { 
                        label: 'Keluar', 
                        data: {!! json_encode($grafik_data->pluck('keluar')) !!}, 
                        borderColor: '#ee5253', 
                        backgroundColor: 'rgba(238, 82, 83, 0.1)', 
                        fill: true, 
                        tension: 0.4, 
                        borderWidth: 3,
                        pointBackgroundColor: '#ee5253'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: 'Plus Jakarta Sans' } } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection