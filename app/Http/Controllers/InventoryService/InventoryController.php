<?php

namespace App\Http\Controllers\InventoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function edit($product_id)
{
    $inventory = Inventory::where('product_id', $product_id)->first();

    if (!$inventory) {
        return redirect()->back()->withErrors(['message' => 'Inventory tidak ditemukan.']);
    }

    return view('add-stok', compact('inventory'));
}

    /**
     * Display the specified resource.
     */
    public function show($product_id)
    {
        $inventory = Inventory::where('product_id', $product_id)->first();

        if (!$inventory) {
            return response()->json(['message' => 'Product not found in inventory'], 404);
        }

        return response()->json([
            'product_id' => $inventory->product_id,
            'stock' => $inventory->stock
        ]);
    }

    public function decrease(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if (!$inventory) {
            return response()->json(['message' => 'Product not found in inventory'], 404);
        }

        if ($inventory->stock < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $inventory->stock -= $request->quantity;
        $inventory->save();

        return response()->json([
            'message' => 'Stock decreased successfully',
            'product_id' => $inventory->product_id,
            'remaining_stock' => $inventory->stock
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
