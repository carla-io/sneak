<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category')->get();
        $categories = Category::all(); // Fetch categories if needed

        return view('admin.product', compact('products', 'categories'));
    }

    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return response()->json(['message' => 'Products imported successfully.']);
    }

    public function show($id)
    {
       $product = Product::find($id);
       if (!$product) {

         return response()->json(['error' => 'Product not found'], 404);
         
        }

         return response()->json($product);
    }
}
