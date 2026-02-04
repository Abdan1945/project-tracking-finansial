@extends('layouts.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-1">Edit Transaksi</h2>
            <p class="text-sm text-slate-500 font-medium mb-0">Perbarui rincian catatan keuangan Anda.</p>
        </div>
        <a href="{{ route('dashboard.transaksi.index') }}" class="btn btn-white border shadow-sm rounded-2xl px-4 fw-bold">
            <i class='bx bx-arrow-back me-1'></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Form Card --}}
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('dashboard.transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Tanggal --}}
                            <div class="col-md-6">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 d-block">Tanggal Transaksi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-slate-50 border-slate-100 rounded-s-2xl"><i class='bx bx-calendar text-slate-400'></i></span>
                                    <input type="date" name="tanggal" class="form-control bg-slate-50 border-slate-100 rounded-e-2xl p-3 text-sm font-bold text-slate-700" value="{{ $transaksi->tanggal }}" required>
                                </div>
                            </div>

                            {{-- Jenis --}}
                            <div class="col-md-6">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 d-block">Jenis Arus Kas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-slate-50 border-slate-100 rounded-s-2xl"><i class='bx bx-transfer-alt text-slate-400'></i></span>
                                    <select name="jenis" class="form-select bg-slate-50 border-slate-100 rounded-e-2xl p-3 text-sm font-bold text-slate-700" required>
                                        <option value="pemasukan" {{ $transaksi->jenis == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                        <option value="pengeluaran" {{ $transaksi->jenis == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 d-block">Kategori</label>
                                <select name="kategori_keuangan_id" class="form-select bg-slate-50 border-slate-100 rounded-2xl p-3 text-sm font-bold text-slate-700" required>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $transaksi->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Akun --}}
                            <div class="col-md-6">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 d-block">Metode Pembayaran / Akun</label>
                                <select name="akun_keuangan_id" class="form-select bg-slate-50 border-slate-100 rounded-2xl p-3 text-sm font-bold text-slate-700" required>
                                    @foreach($akun as $a)
                                        <option value="{{ $a->id }}" {{ $transaksi->akun_id == $a->id ? 'selected' : '' }}>{{ $a->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Jumlah --}}
                            <div class="col-md-12">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 d-block">Nominal (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-indigo-600 border-indigo-600 text-white rounded-s-2xl fw-bold">Rp</span>
                                    <input type="number" name="jumlah" class="form-control bg-slate-50 border-slate-100 rounded-e-2xl p-3 text-lg font-black text-slate-800" value="{{ $transaksi->jumlah }}" required>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-md-12">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 d-block">Keterangan / Catatan</label>
                                <textarea name="keterangan" class="form-control bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-medium text-slate-600" rows="3" placeholder="Contoh: Beli makan siang atau Gaji bulanan">{{ $transaksi->keterangan }}</textarea>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-8 d-flex gap-3">
                            <button type="submit" class="flex-grow-1 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all border-0">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Side Card --}}
        <div class="col-lg-4">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white h-100 position-relative overflow-hidden">
                <div class="position-relative z-index-1">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                        <i class='bx bx-info-circle text-2xl text-indigo-400'></i>
                    </div>
                    <h4 class="fw-black mb-3">Informasi</h4>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Perubahan data pada transaksi akan langsung mempengaruhi laporan keuangan dan saldo pada akun yang Anda pilih.
                    </p>
                    <ul class="list-unstyled space-y-3 m-0">
                        <li class="d-flex align-items-center gap-3 text-xs font-bold">
                            <i class='bx bx-check-circle text-emerald-400 text-lg'></i>
                            Pastikan nominal sudah benar
                        </li>
                        <li class="d-flex align-items-center gap-3 text-xs font-bold">
                            <i class='bx bx-check-circle text-emerald-400 text-lg'></i>
                            Pilih kategori yang sesuai
                        </li>
                    </ul>
                </div>
                {{-- Decoration --}}
                <div class="position-absolute bottom-0 right-0 p-4 opacity-10">
                    <i class='bx bx-edit-alt' style="font-size: 150px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-black { font-weight: 900 !important; }
    .rounded-2xl { border-radius: 1rem !important; }
    .rounded-s-2xl { border-top-left-radius: 1rem !important; border-bottom-left-radius: 1rem !important; }
    .rounded-e-2xl { border-top-right-radius: 1rem !important; border-bottom-right-radius: 1rem !important; }
    .bg-slate-50 { background-color: #f8fafc !important; }
    .border-slate-100 { border-color: #f1f5f9 !important; }
    .z-index-1 { position: relative; z-index: 1; }
</style>
@endsection