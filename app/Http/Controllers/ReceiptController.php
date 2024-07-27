<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReceiptController extends Controller
{
    public function Index(){
        return view('receipt');
    }

    public function summary(Request $request)
    {

        $order = Order::get();
        // Get order IDs from query parameter
        $orderIds = $request->query('order_ids');
        $orderIdsArray = explode(',', $orderIds);

        // Retrieve all orders
        $orders = Order::whereIn('id', $orderIdsArray)->get();

        return view('receipt', ['orders' => $orders]);
    }
}
