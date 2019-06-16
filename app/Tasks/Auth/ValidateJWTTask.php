<?php


namespace App\Tasks\Auth;


use common\abstracts\Task;
use Lcobucci\JWT\ValidationData;

class ValidateJWTTask extends Task
{

    private $user;
    private $token;

    /**
     * ValidateJWTTask constructor.
     * @param $user
     * @param $token
     */
    public function __construct($token,$user)
    {
        $this->user = $user;
        $this->token = $token;
    }


    /**
     * Main method. Implement the business rule
     * @return mixed
     * @throws \Exception
     */
    protected function handle()
    {
        $validationData = new ValidationData();
        $validationData->setIssuer('microauth');
        $validationData->setId($this->user['email']);

        return $this->token->validate($validationData);
    }
}