<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function Index(){
        $orders = Order::with('user')->get();
        return view('admin.order', compact('orders'));
    }

    public function getOrders()
    {
        $orders = Order::with('user')->get();
        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->shipper_id = $request->shipper_id;
        $order->save();

        return response()->json(['success' => true]);
    }

    public function receipt($id)
    {
        $order = Order::with('shipper')->findOrFail($id);
        return view('receipt', compact('order'));
    }

    public function summary(Request $request)
    {
        // Get order IDs from query parameter
        $orderIds = $request->query('order_ids');
        $orderIdsArray = explode(',', $orderIds);

        // Retrieve all orders
        $orders = Order::whereIn('id', $orderIdsArray)->get();

        return view('receipt', ['orders' => $orders]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = $request->input('cart');
    
        \Log::info('Authenticated User:', ['user' => $user]);
        \Log::info('Cart Items:', ['cart' => $request->input('cart')]);
    
        if (!$cart || !is_array($cart)) {
            return response()->json(['error' => 'Invalid cart data'], 400);
        }
    
        $order_ids = []; // Initialize an array to collect order IDs
    
        foreach ($cart as $item) {
            if (!isset($item['product_name'], $item['quantity'], $item['price'])) {
                return response()->json(['error' => 'Incomplete item data'], 400);
            }
    
            // Calculate total price
            $totalPrice = $item['quantity'] * $item['price'];
    
            // Save order to database
            $order = Order::create([
                'user_id' => $user->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'total_price' => $totalPrice,
                'status' => 'Pending',
            ]);
    
            $order_ids[] = $order->id; // Add the new order ID to the array
        }
    
        return response()->json(['message' => 'Checkout successful', 'order_ids' => $order_ids], 200);
    }

}
