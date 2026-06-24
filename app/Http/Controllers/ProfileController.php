<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->ignore($user->id),
            ],

            'phone' => 'nullable|string|max:15',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        if ($request->filled('password')) {
            if (Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }

            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile information updated.');
    }
}
