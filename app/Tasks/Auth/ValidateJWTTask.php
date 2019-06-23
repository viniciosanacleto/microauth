<?php


namespace App\Tasks\Auth;


use common\abstracts\Task;
use Lcobucci\JWT\Signer\Hmac\Sha256;
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
        $signer = new Sha256();
        $validationData = new ValidationData();
        $validationData->setIssuer('microauth');
        $validationData->setId($this->user['email']);


        //Verify signature first
        if(!$this->token->verify($signer,env('AUTH_SIGNATURE'))){
            return false;
        }

        //Then verify the information
        return $this->token->validate($validationData);
    }
}