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
            'nama_akun' => 'required|string|max:255',
            'jenis' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        AkunKeuangan::create([
            'user_id' => Auth::id(),
            'nama_akun' => $request->nama_akun,
            'jenis' => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
        ]);

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun berhasil ditambahkan!');
    }

    public function show($id)
    {
        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($id);
        return view('akun-keuangan.show', compact('akun'));
    }

    public function edit($id)
    {
        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($id);
        return view('akun-keuangan.edit', compact('akun'));
    }

    public function update(Request $request, $id)
    {
        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama_akun' => 'required|string|max:255',
            'jenis' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        $akun->update([
            'nama_akun' => $request->nama_akun,
            'jenis' => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
        ]);

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($id);

        // CEK RELASI: Cegah error Integrity Constraint Violation
        if ($akun->transaksi()->exists()) {
            return redirect()->route('dashboard.akun-keuangan.index')
                ->with('error', "Gagal hapus! Akun '{$akun->nama_akun}' masih digunakan dalam transaksi.");
        }

        $akun->delete();

        return redirect()->route('dashboard.akun-keuangan.index')
            ->with('success', 'Akun berhasil dihapus!');
    }
}