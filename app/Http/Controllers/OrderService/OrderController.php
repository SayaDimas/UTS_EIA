<?php

namespace App\Http\Controllers\OrderService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

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
            'total_price' => 'required|numeric',
        ]);

        $order = Order::create(array_merge($validated, ['status' => 'pending']));

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
