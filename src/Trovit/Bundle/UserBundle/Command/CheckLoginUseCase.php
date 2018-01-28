<?php

namespace Trovit\Bundle\UserBundle\Command;

use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;
use Trovit\Bundle\UserBundle\Utils\CheckLoginResponse;
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

        $check_login_response = new CheckLoginResponse();

        return $check_login_response->getResponse($user, $pass);

    }


}

