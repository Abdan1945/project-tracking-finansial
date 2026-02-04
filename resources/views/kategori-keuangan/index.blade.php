@extends('layouts.dashboard')

@section('content')
<div class="animate__animated animate__fadeIn">
    {{-- Header & Action Section --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-1">Kategori Keuangan</h2>
            <p class="text-sm text-slate-500 font-medium mb-0">Kelola kategori untuk mengelompokkan pemasukan dan pengeluaran Anda.</p>
        </div>
        <div>
            <a href="{{ route('dashboard.kategori-keuangan.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all no-underline">
                <i class='bx bx-plus fs-5'></i>
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="table-responsive">
            <table class="w-full text-left border-collapse m-0">
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
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                    <i class='bx bx-category-alt fs-4'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 m-0 leading-tight">{{ $k->nama_kategori }}</p>
                                    <span class="text-[10px] text-slate-400 font-medium">ID Kategori: #{{ $k->id }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Tipe --}}
                        <td class="px-8 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $k->jenis == 'pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                <div class="w-1.5 h-1.5 rounded-full {{ $k->jenis == 'pemasukan' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                {{ $k->jenis }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-8 py-4">
                            <span class="text-xs font-bold text-slate-600">
                                {{ $k->created_at ? $k->created_at->format('d M Y') : '-' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-8 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                {{-- Tombol Show --}}
                                <a href="{{ route('dashboard.kategori-keuangan.show', $k->id) }}" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-600 hover:text-white transition-all no-underline" title="Lihat Detail">
                                    <i class='bx bx-show fs-5'></i>
                                </a>

                                {{-- Tombol Edit --}}
                                <a href="{{ route('dashboard.kategori-keuangan.edit', $k->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all no-underline" title="Edit">
                                    <i class='bx bx-edit-alt fs-5'></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('dashboard.kategori-keuangan.destroy', $k->id) }}" method="POST" class="inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all border-none cursor-pointer" onclick="return confirm('Hapus kategori ini?')" title="Hapus">
                                        <i class='bx bx-trash fs-5'></i>
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
                                    <i class='bx bx-bookmark-alt display-4'></i>
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
        
        {{-- Pagination --}}
        @if($kategori->hasPages())
        <div class="p-8 border-t border-slate-50 bg-slate-50/30">
            {{ $kategori->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    /* Utility Overrides */
    .font-black { font-weight: 900 !important; }
    .tracking-tight { letter-spacing: -0.5px; }
    
    /* Pagination Fix untuk Laravel + Tailwind di template Sneat */
    nav[role="navigation"] svg { 
        width: 20px; 
        display: inline;
    }
    .pagination {
        margin-bottom: 0;
        justify-content: center;
    }

    /* Table Hover Animation */
    .group:hover .w-10 {
        transform: scale(1.1);
    }
</style>
@endsection