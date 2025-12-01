<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'id_kasir',
        'total',
        'diskon',
        'tunai',
        'kembalian',
        'kode',
    ];

		// Relasi ke Model User (kasir)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }
    
    public function transactionDetail()
		{
		   return $this->hasMany(TransactionDetail::class, 'id_transaksi');
		}
}