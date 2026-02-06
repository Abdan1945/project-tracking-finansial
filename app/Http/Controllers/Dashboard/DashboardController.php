<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard dengan ringkasan data.
     */
    public function index()
    {
        $user = Auth::user();
        $isAdmin = ($user->role === 'admin');

        // 1. Base Query untuk Ringkasan Nominal
        $baseQuery = Transaksi::query();
        if (!$isAdmin) {
            $baseQuery->where('user_id', $user->id);
        }

        // Hitung total dengan clone agar query tidak bertabrakan
        $totalPemasukan = (clone $baseQuery)->where('jenis', 'pemasukan')->sum('jumlah') ?? 0;
        $totalPengeluaran = (clone $baseQuery)->where('jenis', 'pengeluaran')->sum('jumlah') ?? 0;
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // 2. Ambil 5 Transaksi Terakhir dengan Eager Loading
        // Eager loading 'kategori_keuangan' sangat penting untuk performa
        $transactions = Transaksi::with(['kategori_keuangan', 'akun_keuangan', 'user'])
            ->when(!$isAdmin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        // 3. Data Statistik Grafik (Data per bulan tahun berjalan)
        $grafik_data = Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%b') as bulan"),
                DB::raw("SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as keluar"),
                DB::raw("MONTH(tanggal) as bulan_num")
            )
            ->whereYear('tanggal', date('Y'))
            ->when(!$isAdmin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->groupBy('bulan', 'bulan_num')
            ->orderBy('bulan_num', 'asc')
            ->get();

        // 4. Kirim data ke view
        return view('dashboard.index', compact(
            'totalPemasukan', 
            'totalPengeluaran', 
            'saldoAkhir', 
            'transactions', 
            'grafik_data',
            'isAdmin'
        ));
    }

    public function create() 
    { 
        return view('transaksi.create'); 
    }
}