<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function register(Request $request)
    {
        if (User::where('name', $request->name)->first() == null) {
            $user = new User;
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(50);
            $user->save();
            return json_encode(['token' => $user->remember_token, 'id' => $user->id, 'error' => 'none']);
        }
        return json_encode(['error'=> 'nametaken']);
    }

    public function login(Request $request)
    {

        $user = User::where('name', $request->name)->first();
        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                return json_encode(['token' => $user->remember_token, 'id' => $user->id, 'error' => 'none']);
            } else {
                return json_encode(['error' => 'badpass']);
            }

        }
        return json_encode(['error' => 'noname']);
    }

    public function check_token(Request $request)
    {
        $user = User::where('remember_token', $request->token)->first();
        if ($user != null) {
            return json_encode(['status' => 1, 'username' => $user->name, 'id'=> $user->id]);
        } else {
            return json_encode(['status' => 0]);
        }

    }
}
