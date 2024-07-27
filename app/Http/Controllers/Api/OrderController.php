<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Shipper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::select('orders.id', 'users.username as username', 'orders.product_name', 'orders.quantity', 'orders.total_price', 'orders.status', 'shipper.shipper_name as shipper_name', 'orders.shipper_id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('shipper', 'orders.shipper_id', '=', 'shipper.id'); // Join the shippers table

            return DataTables::of($orders)
                ->addColumn('action', function($row) {
                    return '<button class="btn btn-primary select-shipper-btn" data-id="' . $row->id . '">Select Shipper</button>';
                })
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    
    }

    // public function checkout(Request $request)
    // {
    //     // $user = Auth::user();
    //     $user = Auth::user();
    //     $cart = $request->input('cart');

    //     \Log::info('Authenticated User:', ['user' => $user]);
    //     \Log::info('Cart Items:', ['cart' => $request->input('cart')]);


    //     if (!$cart || !is_array($cart)) {
    //         return response()->json(['error' => 'Invalid cart data'], 400);
    //     }

    //     foreach ($cart as $item) {
    //         if (!isset($item['product_name'], $item['quantity'], $item['price'])) {
    //             return response()->json(['error' => 'Incomplete item data'], 400);
    //         }

    //         // Calculate total price
    //         $totalPrice = $item['quantity'] * $item['price'];

    //         // Save order to database
    //         Order::create([
    //             'user_id' => $user->id,
    //             'product_name' => $item['product_name'],
    //             'quantity' => $item['quantity'],
    //             'total_price' => $totalPrice,
    //             'status' => 'Pending',
    //         ]);
    //     }

    //     return response()->json(['message' => 'Checkout successful'], 200);

    // }

    // public function checkout(Request $request)
    // {
    //     $user = Auth::user();
    //     $cart = $request->input('cart');

    //     \Log::info('Authenticated User:', ['user' => $user]);
    //     \Log::info('Cart Items:', ['cart' => $request->input('cart')]);

    //     if (!$cart || !is_array($cart)) {
    //         return response()->json(['error' => 'Invalid cart data'], 400);
    //     }

    //     // Placeholder for the first order ID created
    //     $firstOrderId = null;

    //     foreach ($cart as $index => $item) {
    //         if (!isset($item['product_name'], $item['quantity'], $item['price'])) {
    //             return response()->json(['error' => 'Incomplete item data'], 400);
    //         }

    //         // Calculate total price
    //         $totalPrice = $item['quantity'] * $item['price'];

    //         // Save order to database
    //         $order = Order::create([
    //             'user_id' => $user->id,
    //             'product_name' => $item['product_name'],
    //             'quantity' => $item['quantity'],
    //             'total_price' => $totalPrice,
    //             'status' => 'Pending',
    //         ]);

    //         // Store the first order ID
    //         if ($index == 0) {
    //             $firstOrderId = $order->id;
    //         }
    //     }

    //     // Return the first order ID created
    //     return response()->json(['order_id' => $firstOrderId, 'message' => 'Checkout successful'], 200);
    // }

    // public function store(Request $request)
    // {
    //     $cartItems = Cart::where('user_id', Auth::id())->get();

    //     foreach ($cartItems as $item) {
    //         $product = Product::find($item->product_id);

    //         Order::create([
    //             'user_id' => Auth::id(),
    //             'product_name' => $product->name, // Assuming product has a 'name' attribute
    //             'quantity' => $item->quantity,
    //             'total_price' => $item->total,
    //             'status' => 'Pending'
    //         ]);
    //     }

    //     Cart::where('user_id', Auth::id())->delete();

    //     return response()->json(['success' => 'Order placed successfully!']);
    // }

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

    public function updateStatus(Request $request, $id)
{
    \Log::info('Update Order Status Request:', $request->all());

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->shipper_id = $request->shipper_id;
    $order->save();

    return response()->json(['success' => true]);
}

public function show($id)
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
}
