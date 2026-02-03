@extends('layouts.app')

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn">
    {{-- Header & Action Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Kategori Keuangan</h2>
            <p class="text-sm text-slate-500 font-medium text-decoration-none">Kelola kategori untuk mengelompokkan pemasukan dan pengeluaran Anda.</p>
        </div>
        <div>
            <a href="{{ route('dashboard.kategori-keuangan.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all no-underline">
                <i class='bx bx-plus text-lg'></i>
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Info Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tipe</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Dibuat Pada</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($kategori as $k)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        {{-- Nama Kategori --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 text-slate-500">
                                    <i class='bx bx-category-alt text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 m-0 leading-tight">{{ $k->nama_kategori }}</p>
                                    <span class="text-[10px] text-slate-400 font-medium">ID Kategori: #{{ $k->id }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Tipe --}}
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $k->jenis == 'pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                <div class="w-1.5 h-1.5 rounded-full {{ $k->jenis == 'pemasukan' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                {{ $k->jenis }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-600">
                                {{ $k->created_at ? $k->created_at->format('d M Y') : '-' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('dashboard.kategori-keuangan.edit', $k->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all no-underline">
                                    <i class='bx bx-edit-alt text-lg'></i>
                                </a>
                                <form action="{{ route('dashboard.kategori-keuangan.destroy', $k->id) }}" method="POST" class="inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all border-none cursor-pointer" onclick="return confirm('Hapus kategori ini?')">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                    <i class='bx bx-bookmark-alt text-4xl'></i>
                                </div>
                                <h4 class="text-slate-800 font-black">Belum Ada Kategori</h4>
                                <p class="text-slate-400 text-sm">Anda belum menambahkan kategori keuangan apapun.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kategori->hasPages())
        <div class="p-8 border-t border-slate-50 bg-slate-50/30">
            {{ $kategori->links() }}
        </div>
        @endif
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
    /* Memperbaiki pagination Laravel agar sinkron dengan Tailwind */
    nav[role="navigation"] svg { width: 20px; }
</style>
@endsection