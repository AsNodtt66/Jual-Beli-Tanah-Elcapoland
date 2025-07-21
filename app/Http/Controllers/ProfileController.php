<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'profile_photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'ktp_path' => $user->isSeller() ? 'nullable|file|mimes:jpeg,png,jpg|max:2048' : 'forbidden',
                'npwp_path' => $user->isSeller() ? 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048' : 'forbidden',
            ]);

            // Log data yang divalidasi
            Log::info('Validated data: ', $validated);

            // Handle file uploads
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                    Log::info('Deleted old profile photo: ' . $user->profile_photo);
                }
                $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
                Log::info('New profile photo stored: ' . $validated['profile_photo']);
            }

            if ($user->isSeller()) {
                if ($request->hasFile('ktp_path')) {
                    if ($user->ktp_path) {
                        Storage::disk('public')->delete($user->ktp_path);
                        Log::info('Deleted old KTP: ' . $user->ktp_path);
                    }
                    $validated['ktp_path'] = $request->file('ktp_path')->store('ktp', 'public');
                    Log::info('New KTP stored: ' . $validated['ktp_path']);
                }
                if ($request->hasFile('npwp_path')) {
                    if ($user->npwp_path) {
                        Storage::disk('public')->delete($user->npwp_path);
                        Log::info('Deleted old NPWP: ' . $user->npwp_path);
                    }
                    $validated['npwp_path'] = $request->file('npwp_path')->store('npwp', 'public');
                    Log::info('New NPWP stored: ' . $validated['npwp_path']);
                }
            }

            // Update user
            $user->update($validated);
            Log::info('User updated: ', $user->toArray());

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui profil: ' . $e->getMessage()]);
        }
    }
}