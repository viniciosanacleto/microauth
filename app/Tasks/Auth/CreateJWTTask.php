<?php


namespace App\Tasks\Auth;


use common\abstracts\Task;
use Lcobucci\JWT\Builder as JWTBuilder;

class CreateJWTTask extends Task
{
    private $user;
    private $expirationTime;

    /**
     * CreateJWTTask constructor.
     * @param $user
     * @param $expirationTime
     */
    public function __construct($user, $expirationTime = 3600)
    {
        $this->user = $user;
        $this->expirationTime = $expirationTime;
    }


    /**
     * Main method. Implement the business rule
     * @return mixed
     * @throws \Exception
     */
    protected function handle()
    {
        $time = time();
        $token = (new JWTBuilder())
            ->issuedBy('microauth')
            ->identifiedBy($this->user['email'],true)
            ->issuedAt($time)
            ->expiresAt($time + $this->expirationTime)
            ->withClaim('uid',$this->user['id'])
            ->getToken();

        return $token;
    }
}