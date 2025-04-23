<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Inventory;

class InventoryModelsController extends Controller
{
    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:1'
        ]);

        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }

        $inventory->increment('stock', $request->stock);

        return response()->json(['message' => 'Stock added successfully', 'inventory' => $inventory]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


}
