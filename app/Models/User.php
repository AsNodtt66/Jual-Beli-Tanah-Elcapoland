<?php

namespace App\Models;

use App\Models\Land;
use App\Models\Transaction;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($role)
 * @method boolean isAdmin()
 * @method boolean isSeller()
 * @method boolean isBuyer()
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_photo',
        'ktp_path',
        'npwp_path',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    

    // Method untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    public function lands()
    {
        return $this->hasMany(Land::class);
    }
    
    // ... di dalam class User ...
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteLands()
    {
        return $this->belongsToMany(Land::class, 'favorites');
    }
}