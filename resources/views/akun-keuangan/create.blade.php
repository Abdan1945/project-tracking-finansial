@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Akun Baru</h1>
            <p class="text-slate-500 text-sm">Pisahkan sumber dana Anda agar pelacakan lebih akurat.</p>
        </div>
        <a href="{{ route('dashboard.akun-keuangan.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors no-underline">
            <i class='bx bx-arrow-back'></i>
            <span class="text-sm font-bold">Kembali</span>
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-[2.5rem] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <form action="{{ route('dashboard.akun-keuangan.store') }}" method="POST" class="p-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Nama Akun --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Nama Akun / Rekening</label>
                    <div class="relative">
                        <i class='bx bx-credit-card-front absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl z-10'></i>
                        <input type="text" name="nama_akun" required placeholder="Contoh: BCA Personal, Dompet Utama, Dana"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold text-sm focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                {{-- Jenis Akun --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Jenis Akun</label>
                    <div class="relative">
                        <i class='bx bx-category-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl z-10'></i>
                        <select name="jenis" required
                            class="w-full pl-12 pr-10 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold text-sm focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="tunai" class="text-slate-700">Tunai (Cash)</option>
                            <option value="bank" class="text-slate-700">Bank (Transfer)</option>
                            <option value="e-wallet" class="text-slate-700">E-Wallet (Gopay, OVO, dll)</option>
                        </select>
                    </div>
                </div>

                {{-- Saldo Awal --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Saldo Awal</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-black text-sm z-10">Rp</span>
                        <input type="number" name="saldo_awal" required placeholder="0"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-indigo-600 font-black text-lg focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">
                    </div>
                </div>

            </div>

            <div class="mt-10">
                <button type="submit" 
                    class="w-full py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3 border-none cursor-pointer">
                    <i class='bx bx-save text-xl'></i>
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection