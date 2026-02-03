@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Akun & Rekening</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola semua sumber dana dan saldo awal Anda di sini.</p>
        </div>
        <a href="{{ route('dashboard.akun-keuangan.create') }}" 
           class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all active:scale-95 no-underline">
            <i class='bx bx-plus-circle text-xl'></i>
            <span>Tambah Akun Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Nama Akun</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Jenis</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-[0.2em] text-right">Saldo Awal</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($akun as $a)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                    <i class='bx bx-credit-card-front text-xl'></i>
                                </div>
                                <span class="font-bold text-slate-700">{{ $a->nama_akun }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider 
                                {{ $a->jenis == 'bank' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600' }}">
                                {{ ucfirst($a->jenis) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="font-black text-slate-800 text-lg">
                                <span class="text-slate-400 text-xs font-normal mr-1">Rp</span>{{ number_format($a->saldo_awal, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('dashboard.akun-keuangan.show', $a->id) }}" class="p-2 rounded-lg bg-slate-100 text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition-all">
                                    <i class='bx bx-show text-lg'></i>
                                </a>
                                <form action="{{ route('dashboard.akun-keuangan.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all border-none cursor-pointer">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-slate-400">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection