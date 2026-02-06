<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Validation\Rule;

class KategoriKeuanganController extends Controller
{
    public function index()
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('kategori-keuangan.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori-keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('kategori_keuangan')->where(fn ($query) => $query->where('user_id', Auth::id()))
            ],
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ], [
            'nama_kategori.unique' => 'Kategori dengan nama ini sudah ada!'
        ]);

        KategoriKeuangan::create([
            'user_id' => Auth::id(),
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Nama variabel diubah menjadi $kategori agar sinkron dengan View kamu
     */
    public function show($id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);
        
        // Compact menggunakan 'kategori'
        return view('kategori-keuangan.show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);
        
        return view('kategori-keuangan.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama_kategori' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('kategori_keuangan')
                    ->where(fn ($query) => $query->where('user_id', Auth::id()))
                    ->ignore($id)
            ],
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('dashboard.kategori-keuangan.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($id);

        try {
            DB::transaction(function () use ($kategori) {
                // Hapus transaksi terkait agar tidak error Foreign Key
                if (method_exists($kategori, 'transaksi')) {
                    $kategori->transaksi()->delete();
                }
                $kategori->delete();
            });

            return redirect()->route('dashboard.kategori-keuangan.index')
                ->with('success', 'Kategori dan semua transaksi terkait berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('dashboard.kategori-keuangan.index')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}