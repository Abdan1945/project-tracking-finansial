@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-8 animate__animated animate__fadeIn">
    {{-- Header Section --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Kategori</h2>
            <p class="text-sm text-slate-500 font-medium">Buat kategori baru untuk merapikan catatan keuangan Anda.</p>
        </div>
        <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="p-3 bg-white border border-slate-100 text-slate-400 rounded-2xl hover:text-slate-600 hover:border-slate-200 transition-all shadow-sm">
            <i class='bx bx-x text-2xl'></i>
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] p-8 md:p-12">
        <form action="{{ route('dashboard.kategori-keuangan.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Input Nama Kategori --}}
            <div class="space-y-2">
                <label for="nama_kategori" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Kategori</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-tag-alt text-xl text-slate-300 group-focus-within:text-indigo-500 transition-colors'></i>
                    </div>
                    <input type="text" 
                           name="nama_kategori" 
                           id="nama_kategori" 
                           class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-indigo-500/20 transition-all" 
                           placeholder="Contoh: Gaji, Makanan, Investasi..."
                           required>
                </div>
                @error('nama_kategori')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Jenis/Tipe --}}
            <div class="space-y-2">
                <label for="jenis" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tipe Kategori</label>
                <div class="grid grid-cols-2 gap-4">
                    {{-- Option Pemasukan --}}
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jenis" value="pemasukan" class="peer sr-only" checked>
                        <div class="flex items-center justify-center gap-3 p-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 transition-all">
                            <i class='bx bx-trending-up text-xl'></i>
                            <span class="text-xs font-black uppercase tracking-widest">Pemasukan</span>
                        </div>
                    </label>

                    {{-- Option Pengeluaran --}}
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jenis" value="pengeluaran" class="peer sr-only">
                        <div class="flex items-center justify-center gap-3 p-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-400 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-600 transition-all">
                            <i class='bx bx-trending-down text-xl'></i>
                            <span class="text-xs font-black uppercase tracking-widest">Pengeluaran</span>
                        </div>
                    </label>
                </div>
                @error('jenis')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 flex flex-col gap-3">
                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all">
                    Simpan Kategori
                </button>
                <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="w-full py-4 bg-transparent text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-center hover:bg-slate-50 transition-all no-underline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .animate__fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection