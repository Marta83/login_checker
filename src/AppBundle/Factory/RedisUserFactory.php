<?php

namespace AppBundle\Factory;


use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;
use Trovit\Bundle\UserBundle\Entity\User;
use AppBundle\Service\PredisClient;

class RedisUserFactory
{

    private $user_repository;

    public function __construct(PredisClient $client)
    {
        $this->user_repository =  new RedisUserRepository($client);
    }

    /**
     * array['username']
     *      ['password']
     *
     * @param array $attributes (See above)
     */
    public function create(array $attributes)
    {
        $user = new User ($attributes['username'], $attributes['password']);
        $this->user_repository->insert($user);

        return $user;
    }

    /**
     * array[array['username']
     *            ['password']]
     *
     * @param array $users (See above)
     */
    public function createList(array $users): array
    {
        $data = array();

        foreach($users as $user )
        {
            $user = new User ($user['username'], $user['password']);
            $this->user_repository->insert($user);

            $data[] = $user;
        }

        return $data;
    }


}
