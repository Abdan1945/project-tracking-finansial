<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunKeuanganController extends Controller
{
    public function index()
    {
        // Mengambil akun milik user yang login
        $akun = AkunKeuangan::where('user_id', Auth::id())->get();
        return view('akun-keuangan.index', compact('akun'));
    }

    public function create()
    {
        return view('akun-keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_akun'  => 'required|string|max:255',
            'jenis'      => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        AkunKeuangan::create([
            'user_id'    => Auth::id(),
            'nama_akun'  => $request->nama_akun,
            'jenis'      => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
        ]);

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun keuangan berhasil ditambahkan!');
    }

    // Menggunakan Route Model Binding agar lebih ringkas
    public function show(AkunKeuangan $akunKeuangan)
    {
        $this->authorizeUser($akunKeuangan);
        return view('akun-keuangan.show', ['akun' => $akunKeuangan]);
    }

    public function edit(AkunKeuangan $akunKeuangan)
    {
        $this->authorizeUser($akunKeuangan);
        return view('akun-keuangan.edit', ['akun' => $akunKeuangan]);
    }

    public function update(Request $request, AkunKeuangan $akunKeuangan)
    {
        $this->authorizeUser($akunKeuangan);

        $request->validate([
            'nama_akun'  => 'required|string|max:255',
            'jenis'      => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        $akunKeuangan->update([
            'nama_akun'  => $request->nama_akun,
            'jenis'      => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
        ]);

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy(AkunKeuangan $akunKeuangan)
    {
        $this->authorizeUser($akunKeuangan);

        // CEK RELASI: Menggunakan relasi 'transaksi' yang sudah kita buat di Model
        if ($akunKeuangan->transaksi()->exists()) {
            return redirect()->route('dashboard.akun-keuangan.index')
                ->with('error', "Gagal hapus! Akun '{$akunKeuangan->nama_akun}' memiliki riwayat transaksi.");
        }

        $akunKeuangan->delete();

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun berhasil dihapus!');
    }

    /**
     * Helper untuk memastikan user hanya bisa mengelola datanya sendiri.
     */
    private function authorizeUser(AkunKeuangan $akun)
    {
        if ($akun->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }
    }
}