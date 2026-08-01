<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrator,medical_social_worker,records_officer',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'module' => 'users',
            'description' => "Created user: {$user->name}",
            'new_values' => $user->toArray(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:administrator,medical_social_worker,records_officer',
            'is_active' => 'required|boolean',
        ]);

        $oldValues = $user->toArray();
        $user->update($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'module' => 'users',
            'description' => "Updated user: {$user->name}",
            'old_values' => $oldValues,
            'new_values' => $user->toArray(),
        ]);

        return redirect()->route('users.show', $user)->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'module' => 'users',
            'description' => "Deleted user: {$userName}",
        ]);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function auditLogs()
    {
        if (!Auth::user()->canManageUsers()) {
            abort(403, 'Unauthorized action.');
        }

        $auditLogs = AuditLog::with('user')->latest()->paginate(50);
        return view('audit-logs.index', compact('auditLogs'));
    }
}
