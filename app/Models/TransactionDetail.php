<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        "id_transaksi",
        "id_produk",
        "qty",
        "harga",
        "subtotal",
    ];

		// Relasi ke Model Transaction
    public function transaksi()
    {
        return $this->belongsTo(Transaction::class, 'id_transaksi');
    }
    
		// Relasi ke Model Product
    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
