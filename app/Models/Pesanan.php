<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans'; // ubah sesuai nama tabel kamu

    protected $fillable = [
        'nomor_meja',
        'menu',
        'total',
        'status',
    ];
}
