@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Detail Transaksi</h1>
            <p class="text-slate-500 text-sm">Informasi lengkap mengenai riwayat arus kas Anda.</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('dashboard.transaksi.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors no-underline">
                <i class='bx bx-arrow-back'></i>
                <span class="text-sm font-bold">Kembali</span>
            </a>
        </div>
    </div>

    {{-- Card Detail --}}
    <div class="bg-white rounded-[2.5rem] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <div class="p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Tanggal --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Tanggal Transaksi</label>
                    <div class="flex items-center gap-3 px-4 py-4 bg-slate-50 rounded-2xl text-slate-700 font-bold text-sm">
                        <i class='bx bx-calendar text-slate-400 text-xl'></i>
                        <span>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}</span>
                    </div>
                </div>

                {{-- Jenis --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Jenis Arus Kas</label>
                    <div class="flex items-center gap-3 px-4 py-4 bg-slate-50 rounded-2xl font-bold text-sm {{ $transaksi->jenis == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                        <i class='bx bx-transfer-alt text-xl'></i>
                        <span class="capitalize">{{ $transaksi->jenis }}</span>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Kategori</label>
                    <div class="flex items-center gap-3 px-4 py-4 bg-slate-50 rounded-2xl text-slate-700 font-bold text-sm">
                        <i class='bx bx-category text-slate-400 text-xl'></i>
                        <span>{{ $transaksi->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                    </div>
                </div>

                {{-- Akun --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Sumber Akun/Rekening</label>
                    <div class="flex items-center gap-3 px-4 py-4 bg-slate-50 rounded-2xl text-slate-700 font-bold text-sm">
                        <i class='bx bx-credit-card text-slate-400 text-xl'></i>
                        <span>{{ $transaksi->akun->nama_akun ?? 'Tanpa Akun' }}</span>
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Nominal</label>
                    <div class="flex items-center gap-3 px-4 py-6 bg-slate-50 rounded-2xl text-indigo-600 font-black text-3xl">
                        <span>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Keterangan / Catatan</label>
                    <div class="flex gap-3 px-4 py-4 bg-slate-50 rounded-2xl text-slate-700 font-medium text-sm min-h-[100px]">
                        <i class='bx bx-note text-slate-400 text-xl mt-1'></i>
                        <p class="mt-1 leading-relaxed">{{ $transaksi->keterangan ?? 'Tidak ada catatan.' }}</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi di Bawah --}}
            <div class="mt-10 flex gap-4">
                <a href="{{ route('dashboard.transaksi.index') }}" 
                    class="w-full py-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-black uppercase tracking-widest transition-all text-center no-underline flex items-center justify-center gap-2">
                    Tutup
                </a>
            </div>
        </div>
    </div>
</div>
@endsection