<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return response()->json([
            'status' => true,
            'message' => "Users Listed Successfully",
            'data' => $users,
        ], 200);
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string',
        ]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->role = $request->role;
            $user->save();
            return response()->json(['message' => 'User role updated successfully']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function deactivateUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->is_active = false;
            $user->save();
            return response()->json(['message' => 'User deactivated successfully']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function usersRegistered()
     {
            $usersPerMonth = User::select(DB::raw('COUNT(id) as count'), DB::raw('MONTH(created_at) as month'))
             ->groupBy('month')
             ->orderBy('month')
             ->get();

         return response()->json($usersPerMonth);
    }
}
