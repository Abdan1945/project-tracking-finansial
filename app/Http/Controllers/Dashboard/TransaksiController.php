<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\KategoriKeuangan;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     */
    public function index()
    {
        $transaksi = Transaksi::with(['kategori', 'akun'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10); 

        // Mengarahkan ke resources/views/dashboard/transaksi/index.blade.php
        return view('transaksi.index', compact('transaksi'));
    }

    /**
     * Menampilkan form tambah transaksi.
     */
    public function create()
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->get();
        $akun = AkunKeuangan::where('user_id', Auth::id())->get();

        return view('transaksi.create', compact('kategori', 'akun'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi: Menggunakan nama field sesuai input di Blade kamu
        $request->validate([
            'tanggal'              => 'required|date',
            'jenis'                => 'required|in:pemasukan,pengeluaran',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangan,id',
            'akun_keuangan_id'     => 'required|exists:akun_keuangan,id',
            'jumlah'               => 'required|numeric|min:1',
            'keterangan'           => 'nullable|string|max:255',
        ]);

        // 2. Simpan: Memetakan input form ke kolom database (kategori_id & akun_id)
        Transaksi::create([
            'user_id'     => Auth::id(),
            'tanggal'     => $request->tanggal,
            'jenis'       => $request->jenis,
            'kategori_id' => $request->kategori_keuangan_id, 
            'akun_id'     => $request->akun_keuangan_id,     
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dicatat!');
    }

    /**
     * Menampilkan detail transaksi (Pengganti fungsi Edit).
     */
    public function show($id)
    {
        // Mengambil detail transaksi beserta relasinya
        $transaksi = Transaksi::with(['kategori', 'akun'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Menghapus transaksi.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $transaksi->delete();

        return redirect()->route('dashboard.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}