<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = [];
        return view('cart');
    }
    
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total' => $product->price * $request->quantity,
        ]);

        return response()->json(['success' => 'Product added to cart!']);
    }

    public function getCartItems()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return response()->json($cartItems);
    }
}
