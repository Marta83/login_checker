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

        return unserialize($user);
    }

    public function insert(User $user)
    {
        $this->client->set(
            $this->getKey($user->getUsername()),
            serialize($user)
        );
    }

    private function getKey($username)
    {
        return 'user:'.$username;
    }
}
