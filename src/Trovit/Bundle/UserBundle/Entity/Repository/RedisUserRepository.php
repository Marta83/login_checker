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

    /**
     * @param string $username
     */
    public function loadUserByUsername(string $username): ?User
    {
        $user = $this->client->get($this->getKey($username));
        if (!$user) {
            return null;
        }

        return unserialize($user);
    }

    /**
     * @param User $user
     */
    public function insert(User $user): void
    {
        $this->client->set(
            $this->getKey($user->getUsername()),
            serialize($user)
        );
    }

    private function getKey(string $username): string
    {
        return 'user:'.$username;
    }
}
