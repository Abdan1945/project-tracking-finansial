@extends('layouts.app') {{-- Pastikan extends ke layout yang baru saja kita buat --}}

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Financial Intelligence</h2>
            <p class="text-sm text-slate-500 font-medium">Pantau arus kas dan efisiensi pengeluaran Anda secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">
                Export Report
            </button>
            <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all">
                + Transaksi Baru
            </button>
        </div>
    </div>

    {{-- Stats Cards Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] hover:shadow-indigo-100 hover:shadow-2xl transition-all duration-500">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                    <i class='bx bx-trending-up text-2xl'></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full">INCOME</span>
            </div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Pemasukan</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">
                <span class="text-slate-400 text-sm font-medium italic">Rp</span> 
                {{ number_format($totalMasuk ?? 0, 0, ',', '.') }}
            </h3>
        </div>

        <div class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] hover:shadow-rose-100 hover:shadow-2xl transition-all duration-500">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:scale-110 transition-transform">
                    <i class='bx bx-trending-down text-2xl'></i>
                </div>
                <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-3 py-1 rounded-full">EXPENSE</span>
            </div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Pengeluaran</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">
                <span class="text-slate-400 text-sm font-medium italic">Rp</span> 
                {{ number_format($totalKeluar ?? 0, 0, ',', '.') }}
            </h3>
        </div>

        <div class="group bg-slate-900 p-6 rounded-[2rem] shadow-xl hover:shadow-indigo-500/20 transition-all duration-500 relative overflow-hidden">
            <div class="relative z-10 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-indigo-400">
                        <i class='bx bx-wallet text-2xl'></i>
                    </div>
                    <span class="text-[10px] font-black text-indigo-300 bg-white/10 px-3 py-1 rounded-full uppercase tracking-tighter">Net Worth</span>
                </div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Saldo Akhir</p>
                <h3 class="text-2xl font-black mt-1">
                    <span class="text-slate-500 text-sm font-medium italic">Rp</span> 
                    {{ number_format(($totalMasuk ?? 0) - ($totalKeluar ?? 0), 0, ',', '.') }}
                </h3>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-3xl"></div>
        </div>
    </div>

    {{-- Recent Transactions Section --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="p-8 flex items-center justify-between border-b border-slate-50">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Transaksi Terakhir</h3>
            <a href="#" class="text-xs font-bold text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Deskripsi / Jenis</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse ($transaksiTerbaru ?? [] as $t)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $t->jenis == 'masuk' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    <i class='bx {{ $t->jenis == 'masuk' ? 'bx-plus-circle' : 'bx-minus-circle' }}'></i>
                                </div>
                                <span class="capitalize font-semibold text-slate-600">{{ $t->jenis }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right font-black {{ $t->jenis == 'masuk' ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $t->jenis == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center opacity-30">
                                <i class='bx bx-data text-5xl mb-4'></i>
                                <p class="text-xs font-bold uppercase tracking-[0.3em]">Belum ada data transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Mikro Animasi */
    .animate__fadeIn {
        animation: fadeIn 0.6s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection