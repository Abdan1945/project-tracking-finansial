@extends('layouts.dashboard')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Styling Card Utama */
    .finance-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .finance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    /* Gradient Backgrounds */
    .bg-income { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important; }
    .bg-expense { background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%) !important; }
    .bg-balance { background: linear-gradient(135deg, #696cff 0%, #4e51d8 100%) !important; }

    /* Icon Styling */
    .icon-circle {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    /* Table Customization */
    .table-hover tbody tr:hover {
        background-color: rgba(105, 108, 255, 0.03);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12 mb-4" data-aos="fade-down">
            <div class="card finance-card bg-balance text-white shadow">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Saldo (Net Worth)</h6>
                        <h2 class="text-white fw-bold mb-0">Rp 14.250.000</h2>
                    </div>
                    <div class="icon-circle">
                        <i class="bx bx-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="100">
            <div class="card finance-card bg-income text-white shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 text-white-50 small">Total Pemasukan</p>
                            <h3 class="text-white fw-bold mb-0">Rp 20.000.000</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="bx bx-trending-up"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50"><i class="bx bx-calendar me-1"></i> Bulan ini (Februari)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="200">
            <div class="card finance-card bg-expense text-white shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 text-white-50 small">Total Pengeluaran</p>
                            <h3 class="text-white fw-bold mb-0">Rp 5.750.000</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="bx bx-trending-down"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50"><i class="bx bx-calendar me-1"></i> Bulan ini (Februari)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12" data-aos="fade-up" data-aos-delay="300">
            <div class="card finance-card shadow-sm bg-white">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center bg-transparent">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-transfer-alt me-2 text-primary"></i>Riwayat Arus Kas</h5>
                    <button class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bx bx-download me-1"></i> Ekspor Data
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">Keterangan Transaksi</th>
                                <th class="py-3 text-center">Tipe</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3">Tanggal</th>
                                <th class="py-3 text-end">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-dollar"></i></span>
                                        </div>
                                        <span class="fw-bold">Gaji Bulanan</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge bg-label-success text-success">MASUK</span>
                                </td>
                                <td>Pekerjaan</td>
                                <td class="text-muted">01 Feb 2026</td>
                                <td class="text-end fw-bold text-success">+ Rp 15.000.000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded-circle bg-label-danger"><i class="bx bx-cart"></i></span>
                                        </div>
                                        <span class="fw-bold">Belanja Mingguan</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge bg-label-danger text-danger">KELUAR</span>
                                </td>
                                <td>Kebutuhan</td>
                                <td class="text-muted">02 Feb 2026</td>
                                <td class="text-end fw-bold text-danger">- Rp 1.250.000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-laptop"></i></span>
                                        </div>
                                        <span class="fw-bold">Project Freelance</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge bg-label-success text-success">MASUK</span>
                                </td>
                                <td>Bisnis</td>
                                <td class="text-muted">28 Jan 2026</td>
                                <td class="text-end fw-bold text-success">+ Rp 5.000.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({ duration: 800, once: true });
    });
</script>
@endsection