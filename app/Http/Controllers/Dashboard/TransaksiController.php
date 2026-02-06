<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\{Transaksi, KategoriKeuangan, AkunKeuangan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = ($user->role === 'admin');

        $query = Transaksi::with(['kategori_keuangan', 'akun_keuangan', 'user'])
            ->latest();

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        // Variabel menggunakan $transaksi agar sinkron dengan file Blade Anda
        $transaksi = $query->paginate(10); 
            
        return view('transaksi.index', compact('transaksi', 'isAdmin'));
    }

    public function create()
    {
        $kategori = KategoriKeuangan::whereIn('user_id', [Auth::id(), 1])
                    ->orWhereNull('user_id')
                    ->get();
                
        $akun = AkunKeuangan::whereIn('user_id', [Auth::id(), 1])
                    ->orWhereNull('user_id')
                    ->get();
        
        return view('transaksi.create', compact('kategori', 'akun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'jenis'       => 'required|in:pemasukan,pengeluaran',
            'kategori_id' => 'required|exists:kategori_keuangan,id',
            'akun_id'     => 'required|exists:akun_keuangan,id',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Transaksi::create([
                    'user_id'     => Auth::id(),
                    'tanggal'     => $request->tanggal,
                    'jenis'       => $request->jenis,
                    'kategori_id' => $request->kategori_id,
                    'akun_id'     => $request->akun_id,
                    'jumlah'      => $request->jumlah,
                    'keterangan'  => $request->keterangan,
                ]);

                $akun = AkunKeuangan::findOrFail($request->akun_id);

                if ($request->jenis == 'pemasukan') {
                    $akun->increment('saldo_awal', $request->jumlah);
                } else {
                    $akun->decrement('saldo_awal', $request->jumlah);
                }
            });

            return redirect()->route('dashboard.transaksi.index')->with('success', 'Transaksi berhasil dicatat!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['kategori_keuangan', 'akun_keuangan', 'user'])->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $transaksi->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $query = Transaksi::query();
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        
        $transaksi = $query->findOrFail($id);
        
        $kategori = KategoriKeuangan::whereIn('user_id', [Auth::id(), 1])
                    ->orWhereNull('user_id')
                    ->get();

        $akun = AkunKeuangan::whereIn('user_id', [Auth::id(), 1])
                    ->orWhereNull('user_id')
                    ->get();

        return view('transaksi.edit', compact('transaksi', 'kategori', 'akun'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $transaksi->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tanggal'     => 'required|date',
            'jenis'       => 'required|in:pemasukan,pengeluaran',
            'kategori_id' => 'required|exists:kategori_keuangan,id',
            'akun_id'     => 'required|exists:akun_keuangan,id',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $transaksi) {
                // Rollback saldo lama
                $akunLama = AkunKeuangan::findOrFail($transaksi->akun_id);
                if ($transaksi->jenis == 'pemasukan') {
                    $akunLama->decrement('saldo_awal', $transaksi->jumlah);
                } else {
                    $akunLama->increment('saldo_awal', $transaksi->jumlah);
                }

                // Update data
                $transaksi->update([
                    'tanggal'     => $request->tanggal,
                    'jenis'       => $request->jenis,
                    'kategori_id' => $request->kategori_id,
                    'akun_id'     => $request->akun_id,
                    'jumlah'      => $request->jumlah,
                    'keterangan'  => $request->keterangan,
                ]);

                // Update saldo baru
                $akunBaru = AkunKeuangan::findOrFail($request->akun_id);
                if ($request->jenis == 'pemasukan') {
                    $akunBaru->increment('saldo_awal', $request->jumlah);
                } else {
                    $akunBaru->decrement('saldo_awal', $request->jumlah);
                }
            });

            return redirect()->route('dashboard.transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupdate: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $transaksi->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak punya akses menghapus data ini.');
        }

        try {
            DB::transaction(function () use ($transaksi) {
                $akun = AkunKeuangan::findOrFail($transaksi->akun_id);

                if ($transaksi->jenis == 'pemasukan') {
                    $akun->decrement('saldo_awal', $transaksi->jumlah);
                } else {
                    $akun->increment('saldo_awal', $transaksi->jumlah);
                }

                $transaksi->delete();
            });

            return redirect()->route('dashboard.transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}