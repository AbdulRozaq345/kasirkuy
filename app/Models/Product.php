<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'nama',
        'stok',
        'harga_beli',
        'harga_jual',
        'id_kategori',
        'foto',
        'barcode'
    ];

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Category::class, 'id_kategori');
    }
}
