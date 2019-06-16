<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Tasks\User\CreateUserTask;
use App\Tasks\User\DeleteUserTask;
use App\Tasks\User\UpdateUserTask;
use common\utils\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $createUserTask = new CreateUserTask($request->input());
        return Response::buildFromTask($createUserTask);
    }

//    public function update(Request $request, $id)
//    {
//        $updateUserTask = new UpdateUserTask($id, $request->input());
//        return Response::buildFromTask($updateUserTask);
//    }
//
//    public function delete($id)
//    {
//        $deleteUserTask = new DeleteUserTask($id);
//        return Response::buildFromTask($deleteUserTask);
//    }
//
//    public function getAll(Request $request){
//        $repository = new UserRepository();
//        return Response::buildFromRepository([$repository, 'getAll'],$request->input('limit'));
//    }
//
//    public function getById($id){
//        $repository = new UserRepository();
//        return Response::buildFromRepository([$repository,'getById'],$id);
//    }
//
//    public function getAllRandomCode(){
//        $repository = new UserRepository();
//        return Response::buildFromRepository([$repository,'getAllWithRandomCode']);
//    }
}
