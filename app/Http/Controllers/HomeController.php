<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        // 1. Data Ringkasan (Menyesuaikan variabel di View kamu)
        $total_pemasukan = Transaksi::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah');
        $total_pengeluaran = Transaksi::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah');
        $total_saldo = $total_pemasukan - $total_pengeluaran;

        // 2. Data Transaksi Terbaru
        $transactions = Transaksi::with('kategori')
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        // 3. Data Grafik (Analisis Arus Kas 6 Bulan Terakhir)
        $grafik_raw = Transaksi::where('user_id', $userId)
            ->where('tanggal', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(tanggal, '%b %Y') as bulan"),
                DB::raw("SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as keluar"),
                DB::raw("MAX(tanggal) as tgl")
            )
            ->groupBy('bulan')
            ->orderBy('tgl', 'asc')
            ->get();

        // Pastikan variabel grafik_data tersedia meski data kosong
        $grafik_data = $grafik_raw;

        return view('home', compact(
            'total_pemasukan', 
            'total_pengeluaran', 
            'total_saldo', 
            'transactions',
            'grafik_data'
        ));
    }
}