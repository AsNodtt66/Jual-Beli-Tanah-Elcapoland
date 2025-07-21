<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Land extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'location',
        'area',
        'certificate_number',
        'certificate_file',
        'photos', // Asumsi ini tidak lagi digunakan jika 'images' yang utama
        'images',
        'status',
        'verified'
    ];

    // Cast 'images' to array automatically by Laravel
    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', "%$term%")
                     ->orWhere('location', 'like', "%$term%");
    }

    public function scopeSort($query, $sort)
    {
        if ($sort === 'price_asc') {
            return $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            return $query->orderBy('price', 'desc');
        }
        return $query;
    }

    public function getFirstImageAttribute()
    {
        // 'images' is already cast to an array by the model
        $images = $this->images;
        if (is_array($images) && !empty($images)) {
            // Pastikan path menggunakan forward slashes
            $cleanPath = str_replace(['\\', '/'], '/', $images[0]);
            return $cleanPath;
        }
        return null; // Return null or a default image path if no images
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}