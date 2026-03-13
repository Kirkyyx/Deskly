<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Generate a unique staff display name.
     * e.g. "Juan dela Cruz (IT Staff #3213)"
     */
    private function generateStaffName(string $baseName): string
    {
        do {
            $number = rand(1000, 9999);
            $name   = "{$baseName} (IT Staff #{$number})";
        } while (User::where('name', $name)->exists());

        return $name;
    }

    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:admin,staff,user',
        ]);

        // Auto-append IT Staff badge number if role is staff
        $name = $validated['role'] === 'staff'
            ? $this->generateStaffName($validated['name'])
            : $validated['name'];

        $user = User::create([
            'name'     => $name,
            'username' => strtolower(str_replace(' ', '_', $validated['name'])) . '_' . rand(1000, 9999),
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
        ]);

        AuditLog::log('user_created', [
            'status' => 'success',
        ]);

        return redirect()->route('users.index')
                         ->with('success', "User \"{$user->name}\" created successfully.");
    }

    public function show(User $user)
    {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin') {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'role'  => 'required|string|in:admin,staff,user',
            ]);

            $newRole = $validated['role'];
            $newName = $validated['name'];

            // Changing TO staff — strip any old badge and generate a fresh one
            if ($newRole === 'staff') {
                // Strip existing badge suffix if present (e.g. when re-saving)
                $baseName = preg_replace('/\s*\(IT Staff #\d{4}\)$/', '', $newName);
                $newName  = $this->generateStaffName($baseName);
            }

            // Changing FROM staff — keep just the base name (strip badge)
            if ($newRole !== 'staff' && str_contains($user->name, '(IT Staff #')) {
                $newName = preg_replace('/\s*\(IT Staff #\d{4}\)$/', '', $user->name);
            }

            $user->update([
                'name' => $newName,
                'role' => $newRole,
            ]);
        } else {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);
            $user->update($validated);
        }

        AuditLog::log('user_updated', [
            'status' => 'success',
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        AuditLog::log('user_deleted', [
            'status' => 'success',
        ]);

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}