<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan_produk';
    protected $fillable = [
        'produk_id',
        'customer_id',
        'total_pembayaran',
        'metode_pembayaran',
        'tanggal_pengantaran'
    ];
}
