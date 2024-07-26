<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

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

    // public function getOrders()
    // {
    //     $orders = Order::with('user')->get();

    //     return DataTables::of($orders)
    //         ->addColumn('username', function($order) {
    //             return $order->user->name;
    //         })
    //         ->make(true);
    // }
}
