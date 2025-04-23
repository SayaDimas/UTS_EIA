<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'harga',
    ];

    /**
     * Mendefinisikan relasi ke Inventory (satu produk bisa memiliki banyak stok).
     */
    public function inventories()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }
}
