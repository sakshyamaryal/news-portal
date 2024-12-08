<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('manage users')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('manage users')) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action. You do not have permission to create users.');
        }

        try {
            $roles = ModelsRole::all();
            return view('users.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while loading the create user form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $user->assignRole($request->role);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.create')->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        if (!auth()->user()->hasPermissionTo('manage users')) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action. You do not have permission to edit users.');
        }

        try {
            $roles = ModelsRole::all();
            return view('users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while loading the edit user form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('manage users');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        try {
            if ($request->password) {
                $request->validate([
                    'password' => 'required|min:6',
                ]);
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);
            $user->syncRoles([$request->role]);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.edit', $user->id)->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->hasPermissionTo('manage users')) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action. You do not have permission to delete users.');
        }

        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while deleting the user: ' . $e->getMessage());
        }
    }

    public function showuserdetail(){
        $user = auth()->user();
        return view('users.showuserdetail', compact('user'));
    }

    public function edituserdetail(){
        $user = auth()->user();
        return view('users.edituserdetail', compact('user'));
    }
}