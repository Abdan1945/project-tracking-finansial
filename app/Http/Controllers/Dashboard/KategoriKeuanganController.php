<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriKeuanganController extends Controller
{
    public function index()
    {
        // Ambil data milik user yang sedang login
        $kategori = KategoriKeuangan::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        // Path: resources/views/kategorikeuangan/index.blade.php
        return view('kategori-keuangan.index', compact('kategori'));
    }

    public function create()
    {
        // Path: resources/views/kategorikeuangan/create.blade.php
        return view('kategori-keuangan.create');
    }

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

        // Perhatikan: Tambahkan 'dashboard.' di depan nama route jika di web.php Anda menggunakan ->name('dashboard.')
        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }
}