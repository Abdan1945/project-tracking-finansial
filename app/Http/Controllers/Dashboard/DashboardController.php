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
        $userId = Auth::id();

        // 1. Hitung Ringkasan Nominal (Untuk Widget Atas)
        // Kita gunakan nama variabel camelCase agar rapi dan standar
        $totalPemasukan = Transaksi::where('user_id', $userId)
            ->where('jenis', 'pemasukan')
            ->sum('jumlah') ?? 0;

        $totalPengeluaran = Transaksi::where('user_id', $userId)
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah') ?? 0;

        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // 2. Ambil 5 Transaksi Terakhir dengan Eager Loading
        // Penting: Nama relasi harus sesuai dengan yang ada di Model Transaksi
        $transactions = Transaksi::with(['kategori_keuangan', 'akun_keuangan'])
            ->where('user_id', $userId)
            ->latest('tanggal')
            ->latest('id') // Menghindari duplikasi urutan jika tanggal sama
            ->take(5)
            ->get();

        // 3. Data Statistik Grafik (Data per bulan)
        $grafik_data = Transaksi::where('user_id', $userId)
            ->select(
                DB::raw("DATE_FORMAT(tanggal, '%b') as bulan"),
                DB::raw("SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as keluar")
            )
            ->groupBy('bulan', DB::raw("MONTH(tanggal)"))
            ->orderBy(DB::raw("MONTH(tanggal)"), 'asc')
            ->get();

        // 4. Kirim data ke view
        return view('dashboard.index', compact(
            'totalPemasukan', 
            'totalPengeluaran', 
            'saldoAkhir', 
            'transactions', 
            'grafik_data'
        ));
    }

    // Method resource lainnya bisa kamu isi nanti sesuai kebutuhan CRUD
    public function create() { return view('dashboard.transaksi.create'); }
    public function store(Request $request) { /* Logika simpan di sini */ }
    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}