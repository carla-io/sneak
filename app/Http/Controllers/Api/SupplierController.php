<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request){
        $supplier = Supplier::all();
        return response()->json([
            'status' => true,
            'message' => "Supplier Listed Successfully",
            'data' => $supplier,
        ], 200);
    }

     //Add Supplier
     public function create(Request $request){

        $validateSupplier = Validator::make($request->all(),[
            'supplier_name' => 'required|unique:suppliers,supplier_name',
            'contact_name' => 'required|string',
            'email' => 'required|string',
            'supplier_phone' => 'required|string',
            'address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validateSupplier->fails()){

            // Log::error('Validation errors:', $validateSupplier->errors()->toArray());
            
            return response()->json([
                'status' => false,
                'message' => "validation error",
                'data' => $validateSupplier->errors(),
            ], 422);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        }

        $inputData = array(
            'supplier_name' => $request->supplier_name,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'supplier_phone' => $request->supplier_phone,
            'address' => $request->address,
            'image' => $imageName,
        );

        $suppliers = Supplier::create($inputData);

        return response()->json([
            'status' => true,
            'message' => "Supplier Added Successfully",
            'data' => $suppliers,
        ], 200);

    }

    //Update Supplier
    public function update(Request $request){
        $validateSupplier = Validator::make($request->all(),[
            'supplier_id' => 'required|exists:suppliers,id',
            'supplier_name' => 'required',
            'contact_name' => 'required|string',
            'email' => 'required|string',
            'supplier_phone' => 'required|string',
            'address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validateSupplier->fails()){
            return response()->json([
                'status' => false,
                'message' => "validation error",
                'data' => $validateSupplier->errors(),
            ], 422);
        }

        $suppliers = Supplier::find($request->supplier_id);
        if (!$suppliers) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier not found',
            ], 404);
        }

        $suppliers = Supplier::find($request->supplier_id);
        $suppliers->supplier_name = $request->supplier_name;
        $suppliers->contact_name = $request->contact_name;
        $suppliers->email = $request->email;
        $suppliers->supplier_phone = $request->supplier_phone;
        $suppliers->address = $request->address;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $suppliers->image = $imageName; // Update image name or path
        }

        $suppliers->save();

        return response()->json([
            'status' => true,
            'message' => "Supplier Updated Successfully",
            'data' => $suppliers,
        ], 200);
    }

     // Delete Supplier
     public function delete(Request $request){
        $validateSupplier= Validator::make($request->all(),[
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        if($validateSupplier->fails()){
            return response()->json([
                'status' => false,
                'message' => "validation error",
                'data' => $validateSupplier->errors(),
            ], 422);
        }
        
        // $products = Product::find($request->product_id)->delete();

        $suppliers = Supplier::find($request->supplier_id);
    if (!$suppliers) {
        return response()->json([
            'status' => false,
            'message' => 'Supplier not found',
        ], 404);
    }

    $suppliers->delete();

    return response()->json([
        'status' => true,
        'message' => 'Supplier deleted successfully',
    ], 200);

    }
}
