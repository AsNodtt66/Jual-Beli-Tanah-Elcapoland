<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $users = User::whereIn('role', ['buyer', 'seller'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:buyer,seller',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:verified,unverified,rejected',
        ]);

        try {
            $user->update($validated);
            return redirect()->route('admin.users.index')->with('success',
             'Pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()->with('error',
             'Gagal memperbarui pengguna. Cek log untuk detail.')->withInput();
        }
    }

    public function destroy(User $user)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            // Optionally, delete related data (e.g., lands, transactions)
            if ($user->ktp_path) {
                Storage::disk('public')->delete($user->ktp_path);
            }
            if ($user->npwp_path) {
                Storage::disk('public')->delete($user->npwp_path);
            }
            $user->delete();
            return redirect()->route('admin.users.index')->with('success',
             'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->with('error',
             'Gagal menghapus pengguna. Cek log untuk detail.');
        }
    }
}