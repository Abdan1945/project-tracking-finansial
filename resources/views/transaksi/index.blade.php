@extends('layouts.dashboard')

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Riwayat Transaksi</h2>
            <p class="text-sm text-slate-500 font-medium">Pantau arus kas masuk dan keluar secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.transaksi.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all no-underline">
                <i class='bx bx-plus text-lg'></i>
                Tambah Transaksi
            </a>
            <a href="{{ route('dashboard.report.transaksi.export') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all no-underline">
                <i class='bx bx-download text-lg'></i>
                Export
            </a>
        </div>
    </div>

    {{-- Bitcoin Style Tracking Card --}}
    <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-200 relative overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
        
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            {{-- Total Balance --}}
            <div class="border-r border-slate-800/50">
                <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Total Saldo (Current Balance)</p>
                <h2 class="text-4xl font-black tracking-tighter">
                    <span class="text-indigo-400 text-2xl mr-1">Rp</span>{{ number_format($transaksi->where('jenis', 'pemasukan')->sum('jumlah') - $transaksi->where('jenis', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}
                </h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 rounded-lg text-[10px] font-bold uppercase">
                        <i class='bx bx-up-arrow-alt'></i> Terpantau
                    </span>
                </div>
            </div>

            {{-- Money In & Out (Bitcoin Style Flow) --}}
            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                {{-- Inflow --}}
                <div class="bg-white/5 rounded-3xl p-5 border border-white/5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center">
                            <i class='bx bx-down-arrow-alt text-xl'></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Uang Masuk</span>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-400">+ Rp {{ number_format($transaksi->where('jenis', 'pemasukan')->sum('jumlah'), 0, ',', '.') }}</h3>
                </div>

                {{-- Outflow --}}
                <div class="bg-white/5 rounded-3xl p-5 border border-white/5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 bg-rose-500/20 text-rose-400 rounded-full flex items-center justify-center">
                            <i class='bx bx-up-arrow-alt text-xl'></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Uang Keluar</span>
                    </div>
                    <h3 class="text-xl font-bold text-rose-400">- Rp {{ number_format($transaksi->where('jenis', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    

    {{-- Table Section --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Info Transaksi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Metode/Akun</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jumlah</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($transaksi as $t)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">{{ $t->tanggal->translatedFormat('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $t->created_at->format('H:i') }} WIB</span>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $t->jenis == 'pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    <i class='bx {{ $t->jenis == 'pemasukan' ? 'bx-trending-up' : 'bx-trending-down' }} text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 m-0 leading-tight">{{ $t->kategori_keuangan->nama_kategori ?? 'Tanpa Kategori' }}</p>
                                    <span class="text-[10px] font-black uppercase tracking-widest {{ $t->jenis == 'pemasukan' ? 'text-emerald-500' : 'text-rose-400' }}">
                                        {{ $t->jenis }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-lg">
                                <i class='bx bx-credit-card text-slate-500'></i>
                                <span class="text-xs font-bold text-slate-600">{{ $t->akun_keuangan->nama_akun ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <span class="text-sm font-black {{ $t->jenis == 'pemasukan' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('dashboard.transaksi.show', $t->id) }}" class="p-2 bg-slate-100 text-slate-500 rounded-lg hover:bg-slate-600 hover:text-white transition-all no-underline">
                                    <i class='bx bx-show-alt text-lg'></i>
                                </a>
                                <a href="{{ route('dashboard.transaksi.edit', $t->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all no-underline">
                                    <i class='bx bx-edit-alt text-lg'></i>
                                </a>
                                <form action="{{ route('dashboard.transaksi.destroy', $t->id) }}" method="POST" class="inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all border-none cursor-pointer" onclick="return confirm('Hapus transaksi ini?')">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                    <i class='bx bx-receipt text-4xl'></i>
                                </div>
                                <h4 class="text-slate-800 font-black">Belum Ada Transaksi</h4>
                                <p class="text-slate-400 text-sm">Mulai catat pengeluaran atau pemasukan Anda sekarang.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transaksi->hasPages())
        <div class="p-8 border-t border-slate-50 bg-slate-50/30">
            {{ $transaksi->links() }}
        </div>
        @endif
    </div>
</div>
@endsection