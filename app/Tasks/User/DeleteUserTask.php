<?php


namespace App\Tasks\User;


use App\Models\User;
use App\Repositories\UserRepository;
use common\abstracts\Task;

class DeleteUserTask extends Task
{

    private $id;

    /**
     * DeleteUserTask constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * Main method. Implement the business rule
     * @return mixed
     * @throws \Exception
     */
    protected function handle()
    {
        $repository = new UserRepository();
        try{
            $repository->delete($this->id);
        }
        catch (\Exception $e){
            throw $e;
        }
    }
}