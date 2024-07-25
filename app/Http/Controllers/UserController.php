<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function getAllUsers(Request $request)
    {
        $users = User::all();
        return response()->json($users);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Выполнение поиска пользователей по имени или email
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }
}
