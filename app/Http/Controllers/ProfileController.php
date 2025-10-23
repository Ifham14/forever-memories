<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'guardian_email' => ['nullable', 'email'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
            'profile_picture' => ['nullable', 'image', 'max:5000'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_pictures', $filename);

            // delete old picture if exists
            if ($user->profile_picture) {
                \Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }

            $user->profile_picture = $filename;
        }
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'guardian_email' => $validated['guardian_email'] ?? null,
            'profile_picture' => $user->profile_picture,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}