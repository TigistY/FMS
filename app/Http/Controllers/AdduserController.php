<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\College;
use App\Models\Department;
use App\Models\Directory;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdduserController extends Controller
{
    public function index()
    {
        $users = User::with(['college', 'department', 'directory', 'roles'])->paginate(10);
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        $colleges = College::all();
        $departments = Department::all();
        $directories = Directory::all();
        $roles = Role::all();
        return view('admin.create', compact('colleges', 'departments', 'directories', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'college_id' => 'nullable|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'directory_id' => 'nullable|exists:directories,id',
            'roles' => 'required|array'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'college_id' => $validated['college_id'],
            'department_id' => $validated['department_id'],
            'directory_id' => $validated['directory_id'],
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $colleges = College::all();
        $departments = Department::all();
        $directories = Directory::all();
        $roles = Role::all();
        return view('admin.edit', compact('user', 'colleges', 'departments', 'directories', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'college_id' => 'nullable|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'directory_id' => 'nullable|exists:directories,id',
            'roles' => 'required|array'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'college_id' => $validated['college_id'],
            'department_id' => $validated['department_id'],
            'directory_id' => $validated['directory_id'],
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}