<?php


namespace App\Tasks\User;


use App\Repositories\UserRepository;
use common\abstracts\Task;
use Illuminate\Support\Facades\Hash;


class CreateUserTask extends Task
{
    private $newuser;

    public function __construct($newuser)
    {
        $this->newuser = $newuser;
    }

    /**
     * Main method. Implement the business rule
     * @return mixed
     * @throws \Exception
     */
    protected function handle()
    {
        $repository = new UserRepository();
        try {
            $repository->create($this->newuser);
        } catch (\Exception $e) {
            throw $e;
        }
    }


}