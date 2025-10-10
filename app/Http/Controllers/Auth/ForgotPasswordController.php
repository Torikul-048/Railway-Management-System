<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email']
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        return view('auth.reset-password', [
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Password has been reset successfully! You can now login with your new password.');
    }
}
