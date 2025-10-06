<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::all()]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 2) return response()->json([]);

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->limit(10)->get();

        return response()->json($users);
    }
}