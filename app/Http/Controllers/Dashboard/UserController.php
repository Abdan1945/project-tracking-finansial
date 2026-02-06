<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class UserController extends Controller
{
    public function index()
    {
        $title = 'Delete User!';
        $text  = "Are you sure you want to delete?";
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
            "message" => "Data Berhasil Dibuat",
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
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Data Berhasil Diperbarui",
        ]);

        return redirect()->route('dashboard.users.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Keamanan: Jangan biarkan admin menghapus dirinya sendiri
        if (Auth::id() == $user->id) {
            session()->flash("toast_notification", [
                "level"   => "error",
                "message" => "Anda tidak dapat menghapus akun sendiri!",
            ]);
            return redirect()->route('dashboard.users.index');
        }

        try {
            // Gunakan Transaction agar jika satu gagal, semua dibatalkan
            DB::transaction(function () use ($user) {
                // 1. Hapus semua transaksi melalui relasi akun
                foreach ($user->akunKeuangan as $akun) {
                    $akun->transaksi()->delete();
                }

                // 2. Hapus akun keuangan
                $user->akunKeuangan()->delete();

                // 3. Hapus kategori keuangan
                $user->kategoriKeuangan()->delete();

                // 4. Baru hapus user-nya
                $user->delete();
            });

            session()->flash("toast_notification", [
                "level"   => "success",
                "message" => "User dan seluruh data terkait berhasil dihapus",
            ]);

        } catch (\Exception $e) {
            session()->flash("toast_notification", [
                "level"   => "error",
                "message" => "Gagal menghapus user: " . $e->getMessage(),
            ]);
        }

        return redirect()->route('dashboard.users.index');
    }
}