<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            if ($user) {
                $role = $user->role;
                // Tambahkan pesan notifikasi ke session
                $request->session()->flash('success', 'Login berhasil! Selamat datang, ' . ucfirst($role) . '!');
                return match ($role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'buyer' => redirect()->route('buyer.dashboard'),
                    'seller' => redirect()->route('seller.dashboard'),
                    default => redirect()->route('dashboard'),
                };
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:buyer,seller',
                'phone' => 'required|string',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'phone' => $validated['phone'],
                'status' => $validated['role'] === 'seller' ? 'unverified' : 'verified',
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil! Silakan login.',
                ]);
            }

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran gagal: ' . $e->getMessage(),
                ], 422);
            }
            return redirect()->route('login')->with('error', 'Pendaftaran gagal: ' . $e->getMessage());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                ], 500);
            }
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}