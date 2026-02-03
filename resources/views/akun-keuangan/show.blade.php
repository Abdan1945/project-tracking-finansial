@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('dashboard.akun-keuangan.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 no-underline font-bold transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl'></i>
            <span>Kembali ke Daftar Akun</span>
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-50 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-3xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class='bx bx-credit-card-front text-5xl'></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ $akun->nama_akun }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest mt-2 bg-indigo-100 text-indigo-600">
                            {{ $akun->jenis }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 p-8 rounded-[2rem]">
                    <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Total Saldo</p>
                    <h3 class="text-3xl font-black text-slate-800">
                        <span class="text-slate-400 text-xl font-normal mr-1">Rp</span>{{ number_format($akun->saldo_awal, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="bg-slate-50 p-8 rounded-[2rem]">
                    <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Informasi Lain</p>
                    <p class="text-slate-700 font-bold">Dibuat pada: {{ $akun->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection