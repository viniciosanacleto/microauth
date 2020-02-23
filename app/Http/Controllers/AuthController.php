<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tasks\Auth\CreateJWTTask;
use App\Tasks\Auth\ValidateJWTTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser as JWTParser;

class AuthController extends Controller
{
    /**
     * Generate a new JWT token based on user password
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors(), 'message' => 'Failed to Login'], 400);
        }

        //Get user based on email
        $user = User::where('email', $request['email'])->first();
        if (empty($user)) {
            return response(['message' => 'User not found'], 404);
        }

        //Check password
        if (!Hash::check($request['password'], $user['password'])) {
            return response(['message' => 'Wrong password'], 400);
        }

        //If password pass generate a new token
        $token = (new CreateJWTTask($user))->run();

        //Save the active token
        $user['active_token'] = $token;
        $user->save();

        return response([
            'token' => (string)$token,
            'login_at' => date('Y-m-d H:i:s'),
            'email' => $user->email
        ]);
    }

    /**
     * Verify token availability
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function verify(Request $request)
    {
        //Transform token to object
        $token = (new JWTParser())->parse($request['token']);

        //Check if the user active token is the same of the request
        $user = User::find($token->getClaim('uid'));
        if ($user['active_token'] !== (string)$token) {
            return response(['message' => 'Token not valid'], 401);
        }

        //Check token availability
        $tokenAvailability = (new ValidateJWTTask($token, $user))->run();

        return response(['message'=>'Token is valid']);
    }
}
