<?php


namespace App\Tasks\User;


use App\Repositories\UserRepository;
use common\abstracts\Task;

class UpdateUserTask extends Task
{
    private $id;
    /** @var array $form */
    private $form;

    /**
     * UpdateUserTask constructor.
     * @param $id
     * @param array $form
     */
    public function __construct($id, array $form)
    {
        $this->id = $id;
        $this->form = $form;
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
           $repository->update($this->id,$this->form);
        }
        catch (\Exception $e){
            throw $e;
        }
    }
}