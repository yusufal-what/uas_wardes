<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'gambar',
        'category_id',
    ];

    // Relasi ke tabel kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
