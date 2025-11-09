<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Beri tahu Laravel kalau model ini pakai tabel 'products'
    protected $table = 'products';

    protected $fillable = [
        'nama',
        'harga',
        'kategori',
        'gambar',
    ];
}
