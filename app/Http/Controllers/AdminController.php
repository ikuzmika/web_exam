<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    private function checkAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAdmin();

        $users = User::orderBy('name');

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateRole(Request $request, User $user)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'role' => 'required|string|in:admin,user,organizer',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User role updated.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function block(User $user)
    {
        $this->checkAdmin();

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->withErrors(['user' => 'You cannot block yourself.']);
        }

        $user->update(['is_blocked' => !$user->is_blocked]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User block status was changed successfully.');
    }
}
