<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors(), 'message' => 'Failed to create a new User'], 400);
        }

        try {
            User::create($request->all());
            return response(['message' => 'User successfully created!']);
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage(), 'message' => 'Failed to create a new User'], 500);
        }
    }

    public function checkEmailExist(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors(), 'message' => 'Failed to check email'], 400);
        }

        //Find user
        $user = User::where(["email" => $request->input('email')])->first();
        if (empty($user)) {
            return response(['message' => 'Email not used'], 404);
        }
        return response(['message' => 'Email already taken']);
    }
}
