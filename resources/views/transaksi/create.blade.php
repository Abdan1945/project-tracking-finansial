@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
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

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-6 rounded-xl">
            <h3 class="text-rose-800 font-bold text-sm uppercase tracking-wider">Terjadi Kesalahan</h3>
            <ul class="mt-1 text-rose-600 text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <form action="{{ route('dashboard.transaksi.store') }}" method="POST" class="p-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Tanggal --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Tanggal</label>
                    <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                {{-- Jenis --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Jenis Arus Kas</label>
                    <select name="jenis" id="jenis_transaksi" required
                        class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Income)</option>
                        <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Expense)</option>
                    </select>
                </div>

                {{-- Kategori --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Kategori</label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" data-jenis="{{ $k->jenis }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Akun --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Sumber Akun/Rekening</label>
                    <select name="akun_id" required
                        class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        <option value="">Pilih Akun</option>
                        @foreach ($akun as $a)
                            <option value="{{ $a->id }}" {{ old('akun_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->nama_akun }} (Rp {{ number_format($a->saldo_awal, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nominal --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Nominal (Rp)</label>
                    <input type="number" name="jumlah" required placeholder="0" value="{{ old('jumlah') }}"
                        class="w-full px-4 py-5 bg-slate-50 border-none rounded-2xl text-indigo-600 font-black text-2xl focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Keterangan --}}
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Keterangan / Catatan</label>
                    <textarea name="keterangan" rows="3" placeholder="Contoh: Beli bensin, Gaji bulanan..."
                        class="w-full px-4 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 font-medium focus:ring-2 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full mt-10 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest shadow-xl transition-all border-none cursor-pointer">
                Simpan Transaksi
            </button>
        </form>
    </div>
</div>

<script>
    const jenisSelect = document.getElementById('jenis_transaksi');
    const kategoriSelect = document.getElementById('kategori_id');
    const options = kategoriSelect.querySelectorAll('option');

    function filterKategori(isFirstLoad = false) {
        const selectedJenis = jenisSelect.value;
        
        options.forEach(opt => {
            if (opt.value === "") return;
            const dataJenis = opt.getAttribute('data-jenis');
            
            if (dataJenis === selectedJenis) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });

        // Reset kategori jika user ganti Jenis (Pemasukan/Pengeluaran)
        if (!isFirstLoad) {
            kategoriSelect.value = ""; 
        }
    }

    jenisSelect.addEventListener('change', () => filterKategori(false));
    window.addEventListener('DOMContentLoaded', () => filterKategori(true));
</script>
@endsection