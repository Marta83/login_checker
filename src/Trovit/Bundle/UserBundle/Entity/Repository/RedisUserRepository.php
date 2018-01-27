<?php

namespace Trovit\Bundle\UserBundle\Entity\Repository;

use AppBundle\Service\RedisClient;
use Trovit\Bundle\UserBundle\Entity\User;

class RedisUserRepository implements UserRepository
{
    private $client;

    public function __construct(RedisClient $client)
    {
        $this->client = $client->getClient();
    }

    public function loadUserByUsername($username)
    {
        $user = $this->client->get($this->getKey($username));
        if (!$user) {
            return null;
        }

        $data = unserialize($user);

        return new User($data['username'], $data['password']);
    }

    private function getKey($username)
    {
        return 'user:'.$username;
    }
}
