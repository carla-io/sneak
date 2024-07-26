<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::select('orders.id', 'users.username as username', 'orders.product_name', 'orders.quantity', 'orders.total_price', 'orders.status')
                ->join('users', 'orders.user_id', '=', 'users.id');
    
            return DataTables::of($orders)->make(true);
        }
    
        return view('orders.index'); // Adjust this to your actual view
    }

    public function checkout(Request $request)
    {
        // $user = Auth::user();
        $user = Auth::user();
        $cart = $request->input('cart');

        \Log::info('Authenticated User:', ['user' => $user]);
        \Log::info('Cart Items:', ['cart' => $request->input('cart')]);


        if (!$cart || !is_array($cart)) {
            return response()->json(['error' => 'Invalid cart data'], 400);
        }

        foreach ($cart as $item) {
            if (!isset($item['product_name'], $item['quantity'], $item['price'])) {
                return response()->json(['error' => 'Incomplete item data'], 400);
            }

            // Calculate total price
            $totalPrice = $item['quantity'] * $item['price'];

            // Save order to database
            Order::create([
                'user_id' => $user->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'total_price' => $totalPrice,
                'status' => 'Pending',
            ]);
        }

        return response()->json(['message' => 'Checkout successful'], 200);
    }

    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);

            Order::create([
                'user_id' => Auth::id(),
                'product_name' => $product->name, // Assuming product has a 'name' attribute
                'quantity' => $item->quantity,
                'total_price' => $item->total,
                'status' => 'Pending'
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return response()->json(['success' => 'Order placed successfully!']);
    }
}
