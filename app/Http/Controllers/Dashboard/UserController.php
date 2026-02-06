<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Integration dengan SweetAlert (confirmDelete)
        $title = 'Hapus User!';
        $text  = "Apakah Anda yakin ingin menghapus user ini beserta seluruh datanya?";
        confirmDelete($title, $text);

        $users = User::latest()->paginate(10); 
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:admin,member',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "User berhasil ditambahkan",
        ]);

        return redirect()->route('dashboard.users.index');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user      = User::findOrFail($id);
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|string|in:admin,member',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Data user berhasil diperbarui",
        ]);

        return redirect()->route('dashboard.users.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Proteksi: Admin tidak boleh bunuh diri (hapus akun sendiri)
        if (Auth::id() == $user->id) {
            session()->flash("toast_notification", [
                "level"   => "error",
                "message" => "Anda tidak dapat menghapus akun Anda sendiri!",
            ]);
            return redirect()->route('dashboard.users.index');
        }

        try {
            // Menggunakan DB Transaction agar aman jika terjadi kegagalan di tengah jalan
            DB::transaction(function () use ($user) {
                // URUTAN PENGHAPUSAN (PENTING):
                
                // 1. Hapus Transaksi (Karena transaksi merujuk ke akun, kategori, dan user)
                $user->transaksi()->delete();

                // 2. Hapus Akun Keuangan
                $user->akunKeuangan()->delete();

                // 3. Hapus Kategori Keuangan
                $user->kategoriKeuangan()->delete();

                // 4. Terakhir hapus User-nya
                $user->delete();
            });

            session()->flash("toast_notification", [
                "level"   => "success",
                "message" => "User dan riwayat datanya berhasil dihapus permanen",
            ]);

        } catch (\Exception $e) {
            // Jika masih gagal karena kendala database lainnya
            session()->flash("toast_notification", [
                "level"   => "error",
                "message" => "Gagal menghapus user: Database Constraint Error.",
            ]);
        }

        return redirect()->route('dashboard.users.index');
    }
}