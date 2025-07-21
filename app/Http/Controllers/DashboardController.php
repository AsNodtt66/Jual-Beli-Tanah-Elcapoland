<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Land;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Redirect to role-specific dashboard
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'buyer' => $this->buyerDashboard(),
            'seller' => $this->sellerDashboard(),
            default => redirect('/'),
        };
    }

    /**
     * Admin dashboard
     */
    public function adminDashboard()
    {
        $this->checkAuthorization('isAdmin');
        
        $userCount = User::count();
        $verifiedLandCount = Land::where('verified', true)->count();
        $unverifiedLandCount = Land::where('verified', false)->count();

        return view('dashboard.admin', [
            'user' => Auth::user(),
            'userCount' => $userCount,
            'verifiedLandCount' => $verifiedLandCount,
            'unverifiedLandCount' => $unverifiedLandCount
        ]);
    }

    /**
     * Seller dashboard
     */
    public function sellerDashboard()
    {
        $this->checkAuthorization('isSeller');
        
        $user = Auth::user();
        $lands = $user->lands()->paginate(5);

        return view('dashboard.seller', [
            'user' => $user,
            'lands' => $lands
        ]);
    }

    /**
     * Buyer dashboard
     */
    public function buyerDashboard()
    {
        $this->checkAuthorization('isBuyer');
        
        return view('dashboard.buyer', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Custom authorization method
     */
    private function checkAuthorization($roleMethod)
    {
        if (!Auth::check() || !Auth::user()->{$roleMethod}()) {
            abort(403, 'Unauthorized action.');
        }
    }
}