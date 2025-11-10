<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang bisa diisi secara mass assignment
     * @var array
     */
    protected $fillable = [
        'nama',
        'harga',
        'gambar',
        'category_id',
    ];

    /**
     * Relasi ke model Category (Many to One / Belongs To)
     * Setiap item/produk dimiliki oleh satu kategori
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke model CartItem (One to Many / Has Many)
     * Satu produk bisa ada di banyak keranjang (dalam bentuk cart items)
     * 
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
