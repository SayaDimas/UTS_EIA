<?php
namespace App\Http\Controllers\ProdukService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Inventory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Produk::with('inventories')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = Produk::create($request->only(['nama', 'kategori', 'deskripsi', 'harga']));

        Inventory::create([
            'product_id' => $product->id,
            'stock' => $request->input('stock', 0)
        ]);

        return response()->json(['message' => 'Product created with inventory', 'product' => $product], 201);
    }

    public function show($id)
    {
        $product = Produk::with('inventories')->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);
        $product->update($request->only(['nama', 'kategori', 'deskripsi', 'harga']));

        return response()->json(['message' => 'Product updated']);
    }

    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        return view('edit_product', compact('product'));
}

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);
        $product->inventory()->delete();
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
