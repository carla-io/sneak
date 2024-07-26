<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Controllers\Controller;
use Spatie\Searchable\SearchResult;
// use App\Http\Controllers\Api\Product;
use App\Models\Product;

class SearchController extends Controller
{
    
    public function search(Request $request)
{
    $query = $request->input('query');
    $products = Product::where('product_name', 'like', "%{$query}%")->get(); // Search query

    return response()->json([
        'data' => $products
    ]);
}

}
