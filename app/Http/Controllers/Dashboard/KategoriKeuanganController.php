<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriKeuanganController extends Controller
{
    /**
     * Menampilkan daftar kategori milik user.
     */
    public function index()
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        // Pastikan path view sesuai folder: resources/views/dashboard/kategori-keuangan/index.blade.php
        return view('kategori-keuangan.index', compact('kategori'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('kategori-keuangan.create');
    }

    /**
     * Menyimpan data kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        KategoriKeuangan::create([
            'user_id' => Auth::id(),
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
        ]);

        // Perbaikan: Tambahkan prefix 'dashboard.' agar sesuai dengan route list
        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu kategori.
     */
    public function show($id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);
        
        return view('kategori-keuangan.show', compact('kategori'));
    }

    /**
     * Menampilkan form edit kategori.
     */
    public function edit($id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);
        
        return view('kategori-keuangan.edit', compact('kategori'));
    }

    /**
     * Mengupdate data kategori.
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
        ]);

        // Perbaikan: Konsisten gunakan prefix 'dashboard.'
        return redirect()->route('kategori-keuangan.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus kategori.
     */
    public function destroy($id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);
        $kategori->delete();

        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}