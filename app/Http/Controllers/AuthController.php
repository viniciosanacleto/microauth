<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tasks\Auth\CreateJWTTask;
use App\Tasks\Auth\ValidateJWTTask;
use common\utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser as JWTParser;

class AuthController extends Controller
{
    /**
     * Generate a new JWT token based on user password
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function login(Request $request){
        //Get user based on email
        $user = User::where('email',$request['email'])->first();
        if(empty($user)){
            return Response::build(false,'User not found.');
        }

        //Check password
        if(!Hash::check($request['password'],$user['password'])){
            return Response::build(false, 'Wrong password.');
        }

        //If password pass generate a new token
        $token = (new CreateJWTTask($user,60))->run();

        //Save the active token
        $user['active_token'] = $token;
        $user->save();

        return Response::build(true,['token'=>(string)$token,'loginAt'=>date('Y-m-d H:i:s')]);
    }

    /**
     * Verify token availability
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function verify(Request $request){
        //Transform token to object
        $token = (new JWTParser())->parse($request->token);

        //Check if the user active token is the same of the request
        $user = User::find($token->getClaim('uid'));
        if($user['active_token'] !== (string)$token){
            return Response::build(false,'Token is not valid.');
        }

        //Check token availability
        $tokenAvailability = (new ValidateJWTTask($token,$user))->run();

        return Response::build(true,['token'=>(string)$token,'valid'=>$tokenAvailability]);
    }
}
