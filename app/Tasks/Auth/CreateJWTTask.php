<?php


namespace App\Tasks\Auth;


use common\abstracts\Task;
use Lcobucci\JWT\Builder as JWTBuilder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class CreateJWTTask extends Task
{
    private $user;

    /**
     * CreateJWTTask constructor.
     * @param $user
     * @param $expirationTime
     */
    public function __construct($user)
    {
        $this->user = $user;
    }


    /**
     * Main method. Implement the business rule
     * @return mixed
     * @throws \Exception
     */
    protected function handle()
    {
        $signer = new Sha256();
        $time = time();
        $token = (new JWTBuilder())
            ->issuedBy('microauth')
            ->identifiedBy($this->user['email'],true)
            ->issuedAt($time)
            ->expiresAt($time + env('AUTH_TOKEN_EXPIRATION_TIME'))
            ->withClaim('uid',$this->user['id'])
            ->getToken($signer, new Key(env('AUTH_SIGNATURE')));

        return $token;
    }
}