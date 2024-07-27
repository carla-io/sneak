<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    // public function checkout(Request $request)
    // {
    //     $user = Auth::user();
    //     $cart = $request->input('cart');
        
    //     foreach ($cart as $item) {
    //         Order::create([
    //             'user_id' => $user->id,
    //             'product_name' => $item['name'],
    //             'quantity' => $item['quantity'],
    //             'total_price' => $item['price'] * $item['quantity'],
    //             'status' => 'pending',
    //         ]);
    //     }
        
    //     return response()->json(['success' => true]);
    // }

    // public function index()
    // {
    //     $orders = Order::with('user')->get();
    //     return response()->json($orders);
    // }

    public function receipt($id)
    {
        $order = Order::with('shipper')->findOrFail($id);
        return view('receipt', compact('order'));
    }
}

?>
