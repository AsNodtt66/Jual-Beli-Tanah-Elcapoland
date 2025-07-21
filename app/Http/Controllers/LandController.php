<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LandController extends Controller
{
    // ======================= ADMIN SECTION =======================
    public function adminIndex()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $unverifiedLands = Land::where('verified', false)->paginate(10);
        $verifiedLands = Land::where('verified', true)->paginate(10);
        
        return view('admin.lands.index', compact('unverifiedLands', 'verifiedLands'));
    }

    public function verify(Land $land)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $land->update(['verified' => true]);
            return redirect()->route('admin.lands.index')->with('success', 'Tanah berhasil diverifikasi');
        } catch (\Exception $e) {
            \Log::error('Error verifying land: ' . $e->getMessage());
            return redirect()->route('admin.lands.index')->with('error', 'Gagal memverifikasi tanah. Cek log untuk detail.');
        }
    }

    public function reject(Land $land)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $land->delete();
            return redirect()->route('admin.lands.index')->with('success', 'Tanah berhasil ditolak');
        } catch (\Exception $e) {
            \Log::error('Error rejecting land: ' . $e->getMessage());
            return redirect()->route('admin.lands.index')->with('error', 'Gagal menolak tanah. Cek log untuk detail.');
        }
    }

    public function showAdmin(Land $land)
    {
        return view('admin.lands.show', compact('land'));
    }

    public function checkCertificate(Request $request)
    {
        $certificateNumber = $request->input('certificate_number');
        $landId = $request->input('land_id');
        $exists = Land::where('certificate_number', $certificateNumber)
                    ->where('id', '!=', $landId)
                    ->exists();
        return response()->json(['exists' => $exists]);
    }

    // ======================= SELLER SECTION =======================
    public function sellerIndex()
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Unauthorized action.');
        }
        
        $user = Auth::user();
        $lands = $user->lands()->paginate(10);
        return view('seller.lands.index', compact('lands', 'user'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('seller.lands.create');
    }

    private function validateLand(Request $request, bool $isStore = true)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:10000000000', // Maksimum 10 miliar
            'location' => 'required|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048|extensions:jpeg,png,jpg',
            'certificate_number' => $isStore 
                ? 'nullable|string|max:255|unique:lands,certificate_number'
                : 'nullable|string|max:255|unique:lands,certificate_number,' . $request->route('land')->id,
        ];

        return $request->validate($rules);
    }

    // Di metode store
    public function store(Request $request)
    {
        $validate = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'area' => 'required|numeric',
            'certificate_number' => 'nullable|string|max:255|unique:lands',
            'certificate_file' => 'nullable|file|mimes:pdf|max:2048', // Ubah dari required ke nullable
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('land_photos', 'public');
            }
        }

        $landData = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'area' => $request->area,
            'certificate_number' => $request->certificate_number,
            'images' => $imagePaths, // Simpan sebagai array
        ];

        // Tambahkan certificate_file hanya jika file diunggah
        if ($request->hasFile('certificate_file')) {
            $landData['certificate_file'] = $request->file('certificate_file')->store('land_certificates', 'public');
        }

        $land = Land::create($landData);

        return redirect()->route('seller.lands.index')->with('success', 'Listing tanah berhasil ditambahkan.');
    }

    // Di metode update
    public function update(Request $request, Land $land)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $land->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $this->validateLand($request, false);

        \Log::info('Land listing update attempt', ['land_id' => $land->id, 'user_id' => Auth::id()]);

        try {
            $data = $validated;

            // Pengelolaan gambar baru jika ada
            if ($request->hasFile('images')) {
                $oldImages = is_string($land->images) ? json_decode($land->images, true) : $land->images;
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    if (!$image->isValid()) {
                        return redirect()->back()->with('error', 'Salah satu gambar tidak valid.');
                    }
                    $imagePaths[] = $image->store('land_photos', 'public');
                }
                $data['images'] = $imagePaths; // Simpan sebagai array
            }

            // Perbarui data
            $land->update($data);

            \Log::info('Land listing updated successfully', ['land_id' => $land->id]);

            return redirect()->route('seller.lands.index')->with('success', 'Listing tanah berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating land listing: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui listing tanah. Cek log untuk detail.');
        }
    }

    public function edit(Land $land)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $land->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('seller.lands.edit', compact('land'));
    }

    public function destroy(Land $land)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $land->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        \Log::info('Land listing deletion attempt', ['land_id' => $land->id, 'user_id' => Auth::id()]);

        // Hapus gambar (images)
        $oldImages = is_string($land->images) ? json_decode($land->images, true) : $land->images;
        if (is_array($oldImages)) {
            foreach ($oldImages as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        // Hapus file sertifikat jika ada
        if ($land->certificate_file && Storage::disk('public')->exists($land->certificate_file)) {
            Storage::disk('public')->delete($land->certificate_file);
            \Log::info('Certificate file deleted', ['land_id' => $land->id, 'certificate_file' => $land->certificate_file]);
        }

        $land->delete();
        
        \Log::info('Land listing deleted successfully', ['land_id' => $land->id]);

        return redirect()->route('seller.lands.index')->with('success', 'Listing tanah berhasil dihapus');
    }

    // ======================= PUBLIC SECTION =======================
    public function publicIndex(Request $request)
    {
        $query = Land::where('verified', true)
                    ->search($request->input('search'))
                    ->sort($request->input('sort'));

        if ($request->has('price_range') && $request->price_range) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [$min, $max ?: PHP_INT_MAX]);
        }

        if ($request->has('area') && $request->area) {
            [$min, $max] = explode('-', $request->area);
            $query->whereBetween('area', [$min, $max ?: PHP_INT_MAX]);
        }

        $lands = $query->paginate(12);
        foreach ($lands as $land) {
            \Log::info('Land image check', [
                'land_id' => $land->id,
                'images' => $land->images,
                'firstImage' => $land->firstImage,
                'file_exists' => $land->firstImage ? Storage::disk('public')->exists($land->firstImage) : false
            ]);
        }

        // Hanya set session triggerLogin tanpa redirect langsung
        if ($request->has('redirect') && $request->input('redirect') === 'login') {
            if (!Auth::check()) {
                return view('welcome', compact('lands'))->with('triggerLogin', true);
            } elseif (Auth::check() && !Auth::user()->isBuyer()) {
                return view('welcome', compact('lands'))->with('triggerLogin', true);
            }
        }

        return view('welcome', compact('lands'));
    }

    // ======================= BUYER SECTION =======================
    public function buyerIndex(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isBuyer()) {
            abort(403, 'Unauthorized action.');
        }

        $query = Land::where('verified', true)
                    ->search($request->input('search'))
                    ->sort($request->input('sort'));

        if ($request->has('price_range') && $request->price_range) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [$min, $max ?: PHP_INT_MAX]);
        }

        if ($request->has('area') && $request->area) {
            [$min, $max] = explode('-', $request->area);
            $query->whereBetween('area', [$min, $max ?: PHP_INT_MAX]);
        }

        $lands = $query->paginate(12);
        
        // Tambahkan logika untuk menangani redirect=login
        if ($request->has('redirect') && $request->input('redirect') === 'login') {
            if (!Auth::check()) {
                // Redirect ke halaman login
                return redirect()->route('login');
            } elseif (Auth::check() && !Auth::user()->isBuyer()) {
                // Tampilkan notifikasi untuk non-buyer
                return redirect()->route('buyer.lands.index')->with('message',
                 'Mohon login sebagai Pembeli untuk melanjutkan.')->with('message_type', 'warning');
            }
        }

        return view('buyer.lands.index', compact('lands'));
    }

    public function show(Land $land)
    {
        if (!Auth::check() || !Auth::user()->isBuyer()) {
            abort(403, 'Unauthorized action.');
        }
        
        if (!$land->verified) {
            abort(404, 'Listing tidak ditemukan');
        }

        if (in_array($land->status, ['sold', 'in_negotiation', 'disputed'])) {
            return redirect()->back()->with('error', 'Tanah ini tidak tersedia saat ini');
        }
        \Log::info('Land data loaded', [
            'land_id' => $land->id,
            'images' => $land->images
        ]);
            
        return view('buyer.lands.show', compact('land'));
    }

    public function favorites()
    {
        $user = Auth::user();
        $favoriteLands = $user->favoriteLands()->with('user')->paginate(10);
        return view('buyer.lands.favorites', compact('favoriteLands'));
    }

    public function toggleFavorite(Request $request, Land $land)
    {
        $user = Auth::user();
        $isFavorited = $user->favorites()->where('land_id', $land->id)->exists();

        if ($isFavorited) {
            $user->favorites()->where('land_id', $land->id)->delete();
            return $request->expectsJson()
                ? response()->json(['favorited' => false, 'message' => 'Tanah dihapus dari favorit'])
                : redirect()->back()->with('message', 'Tanah dihapus dari favorit')->with('message_type', 'success');
        }

        Favorite::create(['user_id' => $user->id, 'land_id' => $land->id]);
        return $request->expectsJson()
            ? response()->json(['favorited' => true, 'message' => 'Tanah ditambahkan ke favorit'])
            : redirect()->back()->with('message', 'Tanah ditambahkan ke favorit')->with('message_type', 'success');
    }
}