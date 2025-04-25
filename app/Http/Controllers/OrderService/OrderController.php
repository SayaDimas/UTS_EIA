<?php
namespace App\Http\Controllers\OrderService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Inventory;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with(['user', 'product'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $product = Produk::findOrFail($validated['product_id']);
        $inventory = Inventory::where('product_id', $product->id)->first();

        if (!$inventory || $inventory->stock < $validated['quantity']) {
            return response()->json(['message' => 'Stock not sufficient'], 400);
        }

        $totalPrice = $product->harga * $validated['quantity'];

        $order = Order::create([
            'user_id'     => $validated['user_id'],
            'product_id'  => $validated['product_id'],
            'quantity'    => $validated['quantity'],
            'total_price' => $totalPrice,
            'status'      => 'pending',
        ]);

        $inventory->decrement('stock', $validated['quantity']);

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'product'])->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return response()->json($order);
    }
}
