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
        $users = User::all();
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
            "message" => "Data Successfully Created",
        ]);

        return redirect()->route('dashboard.users.index');
    }

    public function show(string $id)
    {
        //
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
            "message" => "Data Successfully Edited",
        ]);
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash("toast_notification", [
            "level"   => "success",
            "message" => "Data Successfully Deleted",
        ]);
        return redirect()->route('dashboard.users.index');
    }
}
