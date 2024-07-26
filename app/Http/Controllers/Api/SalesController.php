<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ensure user is authenticated

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $sales = Order::select('product_name', \DB::raw('SUM(quantity) as total_quantity'), \DB::raw('SUM(total_price) as total_sales'))
                      ->groupBy('product_name')
                      ->get();

        return response()->json($sales);
    }

}
