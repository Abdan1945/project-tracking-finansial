<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\KategoriKeuangan;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['kategori_keuangan', 'akun_keuangan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10); 

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->get();
        $akun = AkunKeuangan::where('user_id', Auth::id())->get();

        return view('transaksi.create', compact('kategori', 'akun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'              => 'required|date',
            'jenis'                => 'required|in:pemasukan,pengeluaran',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangan,id',
            'akun_keuangan_id'     => 'required|exists:akun_keuangan,id',
            'jumlah'               => 'required|numeric|min:1',
            'keterangan'           => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Simpan Transaksi
                Transaksi::create([
                    'user_id'     => Auth::id(),
                    'tanggal'     => $request->tanggal,
                    'jenis'       => $request->jenis,
                    'kategori_id' => $request->kategori_keuangan_id, 
                    'akun_id'     => $request->akun_keuangan_id,     
                    'jumlah'      => $request->jumlah,
                    'keterangan'  => $request->keterangan,
                ]);

                // 2. Update Saldo Akun
                $akun = AkunKeuangan::findOrFail($request->akun_keuangan_id);
                if ($request->jenis == 'pemasukan') {
                    $akun->increment('saldo_awal', $request->jumlah);
                } else {
                    $akun->decrement('saldo_awal', $request->jumlah);
                }
            });

            return redirect()->route('dashboard.transaksi.index')
                ->with('success', 'Transaksi berhasil dicatat dan saldo diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);

        DB::transaction(function () use ($transaksi) {
            // Kembalikan saldo sebelum dihapus
            $akun = AkunKeuangan::findOrFail($transaksi->akun_id);
            if ($transaksi->jenis == 'pemasukan') {
                $akun->decrement('saldo_awal', $transaksi->jumlah);
            } else {
                $akun->increment('saldo_awal', $transaksi->jumlah);
            }
            $transaksi->delete();
        });

        return redirect()->route('dashboard.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus dan saldo dikoreksi.');
    }
}