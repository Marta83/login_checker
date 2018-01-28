<?php

namespace Trovit\Bundle\UserBundle\Command;

use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;
use Trovit\Bundle\UserBundle\Entity\User;
use AppBundle\Service\RedisClient;

class CheckLoginUseCase {

    private $redis;

    public function __construct(RedisClient $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $username
     * @param string $pass
     */
    public function execute(string $username, string $pass): array
    {
        $user_repository = new RedisUserRepository($this->redis);
        $user = $user_repository->loadUserByUsername($username);

        return $this->getResponse($user, $pass);

    }

    private function getResponse(?User $user, string $pass): array
    {
        $success = $user && $pass == $user->getPassword();
        $message = 'User and Password match.';

        if(!$user){
           $message = "User does not exist.";
        }
        elseif($pass != $user->getPassword() ){
           $message =  "User and Password do not match.";
        }

        return array('success' => $success,
                     'message' => $message);
    }


}

