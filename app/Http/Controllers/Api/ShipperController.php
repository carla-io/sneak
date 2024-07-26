<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipper;
use Illuminate\Support\Facades\Validator;

class ShipperController extends Controller
{
    public function index(Request $request){
        $shipper = Shipper::all();
        return response()->json([
            'status' => true,
            'message' => "Shipper Listed Successfully",
            'data' => $shipper,
        ], 200);
    }

    //Add Shipper
    public function create(Request $request){

        $validateShipper = Validator::make($request->all(),[
            'shipper_name' => 'required|unique:shipper,shipper_name',
            'shipper_contact' => 'required|string',
            'shipper_address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validateShipper->fails()){

            // Log::error('Validation errors:', $validateShipper->errors()->toArray());
            
            return response()->json([
                'status' => false,
                'message' => "validation error",
                'data' => $validateShipper->errors(),
            ], 422);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        }

        $inputData = array(
            'shipper_name' => $request->shipper_name,
            'shipper_contact' => $request->shipper_contact,
            'shipper_address' => $request->shipper_address,
            'image' => $imageName,
        );

        $shipper = Shipper::create($inputData);

        return response()->json([
            'status' => true,
            'message' => "Shipper Added Successfully",
            'data' => $shipper,
        ], 200);

    }


    //Update Shipper
    public function update(Request $request){
        $validateShipper = Validator::make($request->all(),[
            'shipper_id' => 'required|exists:shipper,id',
            'shipper_name' => 'required|string',
            'shipper_contact' => 'required|string',
            'shipper_address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validateShipper->fails()){
            return response()->json([
                'status' => false,
                'message' => "validation error",
                'data' => $validateShipper->errors(),
            ], 422);
        }

        $shipper = Shipper::find($request->shipper_id);
        if (!$shipper) {
            return response()->json([
                'status' => false,
                'message' => 'Shipper not found',
            ], 404);
        }

        $shipper = Shipper::find($request->shipper_id);
        $shipper->shipper_name = $request->shipper_name;
        $shipper->shipper_contact = $request->shipper_contact;
        $shipper->shipper_address = $request->shipper_address;
    

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $shipper->image = $imageName; // Update image name or path
        }

        $shipper->save();

        return response()->json([
            'status' => true,
            'message' => "Shipper Updated Successfully",
            'data' => $shipper,
        ], 200);
    }

    // Delete Shipper
    public function delete(Request $request){
        $validateShipper= Validator::make($request->all(),[
            'shipper_id' => 'required|exists:shipper,id',
        ]);

        if($validateShipper->fails()){
            return response()->json([
                'status' => false,
                'message' => "validation error",
                'data' => $validateShipper->errors(),
            ], 422);
        }
        
        // $products = Product::find($request->product_id)->delete();

        $shipper = Shipper::find($request->shipper_id);
    if (!$shipper) {
        return response()->json([
            'status' => false,
            'message' => 'Shipper not found',
        ], 404);
    }

    $shipper->delete();

    return response()->json([
        'status' => true,
        'message' => 'Shipper deleted successfully',
    ], 200);

    }

}
