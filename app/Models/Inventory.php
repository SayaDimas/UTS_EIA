<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['product_id', 'stock'];
    public $timestamps = false;

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
