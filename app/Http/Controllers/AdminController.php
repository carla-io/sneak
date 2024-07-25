<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function updateRole(Request $request, $userId)
    {
        $user = User::find($userId);
        if (!$user || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => 'User role updated successfully']);
    }

    public function deactivateUser($userId)
    {
        $user = User::find($userId);
        if (!$user || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user->is_active = false;
        $user->save();

        return response()->json(['success' => 'User deactivated successfully']);
    }
}
