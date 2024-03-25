<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        //return User::all();
        $user_id = $request->query('userId');
    
        $user = User::where('user_id', $user_id)->select('user_name', 'user_cash', 'user_id')->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found', 'user_id' => $user_id], 404);
        }
    }

    public function balanceDown(Request $request)
    {
        $user_id = $request->input('userid');
        $amount = $request->input('amount');

        $setCash = User::where('user_id', $user_id)->decrement('user_cash', $amount);

        if ($setCash) {
            return response()->json($setCash);
        }

    }

    public function balanceUp(Request $request)
    {
        $user_id = $request->input('userId');
        $amount = $request->input('amount');

        $setCash = User::where('user_id', $user_id)->increment('user_cash', $amount);

        if ($setCash) {
            return response()->json($setCash);
        }

    }

    public function getUsers()
    {
        $users = User::select('user_id', 'user_name')->get();

        if ($users) {
            return response()->json($users);
        } else {
            return response()->json(['message' => 'Users not found'], 404);
        }
    }

}
