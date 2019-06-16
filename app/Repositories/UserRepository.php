<?php


namespace App\Repositories;


use App\Models\User;
use common\abstracts\Repository;

class UserRepository extends Repository
{
    protected $model = User::class;

    /**
     * Get the list of all Users and manipulate to generate a random code for each one
     * @return array
     * @throws \Exception
     */
    public function getAllWithRandomCode(){
        $allUsers = $this->getAll()->toArray();
        return array_map(function ($element){
            $element['randomCode'] = mt_rand();
            return $element;
        },$allUsers);
    }

}