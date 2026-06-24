<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

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

        $users = User::orderBy('id')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function updateInfo(Request $request, User $user)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->ignore($user)
            ],
            'phone' => 'nullable|string|max:15'
        ]);

        $user->update($validated);
        return redirect()->route('admin.users.index')
            ->with('success', __('controllers.user_info_update'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function updateRole(Request $request, User $user)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'role' => 'required|string|in:admin,user,organizer,secretary',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', __('controllers.user_role_update'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function block(User $user)
    {
        $this->checkAdmin();

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->withErrors(['user' => __('controllers.user_admin')]);
        }

        $user->update(['is_blocked' => !$user->is_blocked]);

        return redirect()->route('admin.users.index')
            ->with('success', __('controllers.user_block'));
    }
}
