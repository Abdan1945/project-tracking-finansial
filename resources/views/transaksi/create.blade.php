@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Transaksi</h1>
            <p class="text-slate-500 text-sm">Catat arus kas masuk atau keluar Anda secara akurat.</p>
        </div>
        <a href="{{ route('dashboard.transaksi.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors no-underline">
            <i class='bx bx-arrow-back'></i>
            <span class="text-sm font-bold">Kembali</span>
        </a>
    </div>

    {{-- Tampilkan Pesan Error Validasi --}}
    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-6 rounded-xl">
            <div class="flex">
                <i class='bx bx-error-circle text-rose-500 text-xl mr-3'></i>
                <div>
                    <h3 class="text-rose-800 font-bold text-sm uppercase tracking-wider">Terjadi Kesalahan</h3>
                    <ul class="mt-1 text-rose-600 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Card Form --}}
    <div class="bg-white rounded-[2.5rem] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <form action="{{ route('dashboard.transaksi.store') }}" method="POST" class="p-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Tanggal --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Tanggal Transaksi</label>
                    <div class="relative">
                        <i class='bx bx-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl z-10'></i>
                        <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                </div>

                {{-- Jenis --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Jenis Arus Kas</label>
                    <div class="relative">
                        <i class='bx bx-transfer-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl z-10'></i>
                        <select name="jenis" required
                            class="w-full pl-12 pr-10 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold text-sm focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Income)</option>
                            <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Expense)</option>
                        </select>
                    </div>
                </div>

                {{-- Bagian Kategori --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Kategori</label>
                    <div class="relative">
                        <i class='bx bx-category absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl z-10'></i>
                        <select name="kategori_keuangan_id" required
                            class="w-full pl-12 pr-10 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold text-sm focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="" disabled selected class="text-slate-400">Pilih Kategori</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_keuangan_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Akun --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Sumber Akun/Rekening</label>
                    <div class="relative">
                        <i class='bx bx-credit-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl z-10'></i>
                        <select name="akun_keuangan_id" required
                            class="w-full pl-12 pr-10 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold text-sm focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="" disabled selected class="text-slate-400">Pilih Akun</option>
                            @foreach ($akun as $a)
                                <option value="{{ $a->id }}" {{ old('akun_keuangan_id') == $a->id ? 'selected' : '' }}>{{ $a->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-black text-sm z-10">Rp</span>
                        <input type="number" name="jumlah" required placeholder="0" value="{{ old('jumlah') }}"
                            class="w-full pl-12 pr-4 py-5 bg-slate-50 border-none rounded-2xl text-indigo-600 font-black text-2xl focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Keterangan / Catatan</label>
                    <div class="relative">
                        <i class='bx bx-note absolute left-4 top-5 text-slate-400 text-xl z-10'></i>
                        <textarea name="keterangan" rows="3" placeholder="Contoh: Beli kopi di Starbucks..."
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-medium text-sm focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <button type="submit" 
                    class="w-full py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3 border-none cursor-pointer">
                    <i class='bx bx-check-double text-xl'></i>
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection