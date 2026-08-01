<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.']);
            }

            // Log the login
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'module' => 'authentication',
                'description' => 'User logged in',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log the logout
        if ($user) {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'module' => 'authentication',
                'description' => 'User logged out',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegistrationForm()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrator,medical_social_worker,records_officer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        // Log the registration
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'module' => 'users',
            'description' => "Created new user: {$user->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'new_values' => $user->toArray(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // For prototype, just show success message
        // In production, implement actual email sending
        return back()->with('success', 'Password reset link sent to your email.');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // For prototype, just show success message
        // In production, implement actual password reset logic
        return redirect('/login')->with('success', 'Password reset successfully.');
    }
}
