<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Delete User!';
        $text  = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // UBAH: Gunakan paginate() bukan all() agar method firstItem() dan links() di view bekerja
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
        $user->delete();

        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Data Berhasil Dihapus",
        ]);

        return redirect()->route('dashboard.users.index');
    }
}