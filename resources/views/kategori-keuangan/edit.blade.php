@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Edit Kategori</h1>
            <p class="text-slate-500 text-sm">Ubah informasi kategori keuangan Anda.</p>
        </div>
        <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="text-slate-500 hover:text-indigo-600 transition-colors no-underline flex items-center gap-2">
            <i class='bx bx-arrow-back'></i>
            <span class="text-sm font-bold">Kembali</span>
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        {{-- Sesuai dengan Controller, kita gunakan variabel $kategori --}}
        <form action="{{ route('dashboard.kategori-keuangan.update', $kategori->id) }}" method="POST" class="p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                {{-- Nama Kategori --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" 
                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700 transition-all"
                        placeholder="Contoh: Gaji, Makanan, Transportasi" required>
                    @error('nama_kategori') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Jenis Kategori</label>
                    <div class="relative">
                        <select name="jenis" class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700 transition-all appearance-none cursor-pointer">
                            <option value="pemasukan" {{ (old('jenis', $kategori->jenis) == 'pemasukan') ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ (old('jenis', $kategori->jenis) == 'pengeluaran') ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        <i class='bx bx-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl'></i>
                    </div>
                    @error('jenis') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit" class="w-full mt-10 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-200 border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection