<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Hitung Ringkasan Nominal
        $total_pemasukan = Transaksi::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah') ?? 0;
        $total_pengeluaran = Transaksi::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah') ?? 0;
        $total_saldo = $total_pemasukan - $total_pengeluaran;

        // 2. Data Statistik Grafik (6 Bulan Terakhir)
        $grafik_data = Transaksi::where('user_id', $userId)
            ->select(
                DB::raw("DATE_FORMAT(tanggal, '%b') as bulan"),
                DB::raw("SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as keluar")
            )
            ->groupBy('bulan', DB::raw("MONTH(tanggal)"))
            ->orderBy(DB::raw("MONTH(tanggal)"), 'asc')
            ->get();

        // 3. Ambil 8 Transaksi Terakhir
        $transactions = Transaksi::with('kategori')
            ->where('user_id', $userId)
            ->latest('tanggal')
            ->take(8)
            ->get();

        return view('dashboard.index', compact(
            'total_pemasukan', 
            'total_pengeluaran', 
            'total_saldo', 
            'transactions', 
            'grafik_data'
        ));
    }

    // Method resource lainnya (kosongkan dulu tidak apa-apa)
    public function create() { return view('dashboard.create'); }
    public function store(Request $request) { }
    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}