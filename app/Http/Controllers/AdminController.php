<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('journeys');
        return view('admin.user-show', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('admin.users.show', $user)->with('success', 'Password updated successfully.');
    }

    public function toggleActive(Request $request, User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->is_active ? 'activated' : 'deactivated',
            'user_id' => $user->id,
        ]);
    }
}
